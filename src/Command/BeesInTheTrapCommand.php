<?php

namespace App\Command;

use App\Entity\Hive;
use App\Entity\Player;
use App\Factory\BeeFactory;
use App\Game\AttackService;
use App\Game\GameEngine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BeesInTheTrapCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('beesinthetrap:play')
            ->addOption(
                'auto',
                null,
                InputOption::VALUE_NONE,
                'Auto play without user input... but where\'s the fun in that?'
            )
            ->setDescription('Play Bees in the Trap');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $hive = new Hive(new BeeFactory());
        $player = new Player();
        $attackService = new AttackService();
        $engine = new GameEngine($hive, $player, $attackService);

        $autoPlay = $input->getOption('auto');
        $output->writeln($autoPlay ? 'Starting auto-play mode...' : '');

        while (!$engine->isOver()) {
            $output->writeln($engine->playerTurn());
            $beesTurn = $engine->beesTurn();
            if ($beesTurn !== null) {
                $output->writeln("Hit");
            } else {
                $output->writeln("All bees are dead! You won!");
                break;
            }

            $output->writeln('Your HP: ' . $player->getHp());
            $output->writeln('Bees alive: ' . count($hive->getAliveBees()));
        }
        $output->writeln('--- GAME OVER ---');
        $output->writeln('Hits dealt: ' . $player->getHits());
        $output->writeln('Stings taken: ' . $player->getStings());
        $output->writeln($player->isAlive() ? 'You survived!' : 'You died!');

        return Command::SUCCESS;
    }
}
