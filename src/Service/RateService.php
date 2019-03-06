<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Rate;
use Symfony\Component\DomCrawler\Crawler;

class RateService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * wget "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.zip"
     * unzip eurofxref-hist.zip
     *
     * @return array
     */
    public function getHistory()
    {
        $rates = file_get_contents(__DIR__ . '/../../eurofxref-hist.csv');
        $rows = explode( "\n", $rates);
        array_shift($rows);
        return $rows;
    }

    /**
     * @param $row
     *
     * @return bool|object
     */
    public function get($row)
    {
        $dayRates = explode( ",", $row);
        $eur2usd = $dayRates[1];
        $eur2rub = $dayRates[23];
        if (is_numeric($eur2usd) && is_numeric($eur2rub)) {
            $usd2rub = round($eur2rub / $eur2usd, 4);

            return (object) [
                'date' => $dayRates[0],
                'usd' => $usd2rub,
                'eur' => $eur2rub
            ];
        }

        return false;
    }

    /**
     * @param $rate
     */
    public function add($rate)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $rate->date);

        $usdRate = new Rate();
        $usdRate->setName('usd-rub');
        $usdRate->setValue($rate->usd);
        $usdRate->setDate($date);
        $this->em->persist($usdRate);

        $eurRate = new Rate();
        $eurRate->setName('eur-rub');
        $eurRate->setValue($rate->eur);
        $eurRate->setDate($date);
        $this->em->persist($eurRate);
    }

    public function flush()
    {
        $this->em->flush();
    }

    public function addTodayRates()
    {
        $rate = $this->getTodayRates();
        $date = \DateTime::createFromFormat('Y-m-d', $rate->date);
        $todayRate = $this->em->getRepository(Rate::class)->findOneBy(['date' => $date]);

        if (!$todayRate) {
            $this->add($rate);
            $this->em->flush();
        }
    }

    /**
     * https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html
     *
     * @return object
     */
    private function getTodayRates()
    {
        $xml = file_get_contents('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');

        preg_match_all("/time='(.*)'/", $xml, $matches, PREG_SET_ORDER, 0);
        $date = $matches[0][1];

        preg_match_all("/USD' rate='(.*)'/", $xml, $matches, PREG_SET_ORDER, 0);
        $eur2usd = $matches[0][1];

        preg_match_all("/RUB' rate='(.*)'/", $xml, $matches, PREG_SET_ORDER, 0);
        $eur2rub = $matches[0][1];

        return (object) [
            'date' => $date,
            'usd' => round($eur2rub / $eur2usd, 4),
            'eur' => $eur2rub,
        ];
    }
}