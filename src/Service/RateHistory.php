<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Rate;

class RateHistory
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getHistory()
    {
        $rates = file_get_contents(__DIR__ . '/../../eurofxref-hist.csv');
        $rows = explode( "\n", $rates);
        array_shift($rows);
        return $rows;
    }

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
}