<?php

namespace App\Command;

use App\Entity\Hive;
use App\Entity\Player;
use App\Game\GameEngine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class BeesInTheTrapCommand extends Command
{
    public function __construct(
        private readonly GameEngine $engine,
        private readonly Player $player,
        private readonly Hive $hive
    ) {
        parent::__construct();
    }

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
        $helper = $this->getHelper('question');
        $autoPlay = $input->getOption('auto');
        $output->writeln($autoPlay ? 'Starting auto-play mode...' : '');

        while (!$this->engine->isOver()) {
            if (!$autoPlay) {
                $question = new Question('Type "hit" to attack: ');
                $answer = strtolower(trim($helper->ask($input, $output, $question)));

                if ($answer !== 'hit') {
                    $output->writeln('Invalid action.');
                    continue;
                }
            }

            $output->writeln($this->engine->playerTurn());
            $beesTurn = $this->engine->beesTurn();
            if ($beesTurn !== null) {
                $output->writeln("Hit");
            } else {
                $output->writeln("All bees are dead! You won!");
                break;
            }

            $output->writeln('Your HP: ' . $this->player->getHp());
            $output->writeln('Bees alive: ' . count($this->hive->getAliveBees()));
        }

        $output->writeln('--- GAME OVER ---');
        $output->writeln('Hits dealt: ' . $this->player->getHits());
        $output->writeln('Stings taken: ' . $this->player->getStings());
        $output->writeln($this->player->isAlive() ? 'You survived!' : 'You died!');

        return Command::SUCCESS;
    }
}
