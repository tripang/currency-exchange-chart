<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Service\RateService;

class UpdateRatesCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:update-rates';

    private $rateHistory;

    public function __construct(RateService $rateHistory)
    {
        $this->rateHistory = $rateHistory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Update rates.')
            ->setHelp('Update rates.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Update rates',
            '=================================',
            '',
        ]);

        $this->rateHistory->addTodayRates();

        $output->writeln('Rates Updated.');
    }
}
