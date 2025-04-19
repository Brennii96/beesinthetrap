<?php

namespace App\Command;

use App\Entity\Hive;
use App\Entity\Player;
use App\Game\GameEngine;
use App\Game\NarratorServiceInterface;
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
        private readonly Hive $hive,
        private readonly NarratorServiceInterface $narrator
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
        if ($autoPlay) {
            $output->writeln($this->narrator->autoPlayMode());
        }

        while (!$this->engine->isOver()) {
            if (!$autoPlay && !$this->checkForPlayerInput($input, $output, $helper)) {
                continue;
            }
            $this->handleTurns($output);
            $output->writeln($this->narrator->statsAfterTurn($this->player, $this->hive));
        }

        $output->writeln($this->narrator->gameOver($this->player, $this->hive));
        return Command::SUCCESS;
    }

    private function handleTurns(OutputInterface $output): void
    {
        $playerTurn = $this->engine->playerTurn();
        $output->writeln(
            $playerTurn->hit
                ? $this->narrator->playerHit($playerTurn->bee)
                : $this->narrator->playerMiss()
        );

        $beesTurn = $this->engine->beesTurn();
        $output->writeln(
            $beesTurn->hit
                ? $this->narrator->beeHit($beesTurn->bee)
                : $this->narrator->beeMiss($beesTurn->bee ?? $playerTurn->bee)
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $helper
     * @return bool
     */
    private function checkForPlayerInput(InputInterface $input, OutputInterface $output, $helper): bool
    {
        $question = new Question($this->narrator->playerInstruction());
        $answer = strtolower(trim($helper->ask($input, $output, $question)));

        if ($answer !== 'hit') {
            $output->writeln($this->narrator->invalidAction());
            return false;
        }

        return true;
    }
}
