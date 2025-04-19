<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BeesInTheTrapCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('beesinthetrap:play')
            ->setDescription('Play Bees in the Trap');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Bees in the Trap');
        return Command::SUCCESS;
    }
}
