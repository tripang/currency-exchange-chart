<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Service\RateHistory;

class LoadRatesHistoryCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:load-rates-history';

    private $rateHistory;

    public function __construct(RateHistory $rateHistory)
    {
        $this->rateHistory = $rateHistory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create historical reference rates.')
            ->setHelp('Create historical reference rates');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Create historical reference rates',
            '=================================',
            '',
        ]);

        $rateHistory = $this->rateHistory->getHistory();
        foreach ($rateHistory as $row) {
            $rate = $this->rateHistory->get($row);

            if (!$rate) {
                break;
            }

            $output->writeln($rate->date.' '.$rate->usd.' '.$rate->eur);
            $this->rateHistory->add($rate);
        }

        $this->rateHistory->flush();
        $output->writeln('Rates history saved.');
    }
}
