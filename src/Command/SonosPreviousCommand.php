<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosPreviousCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:prev');
        $this->setDescription('Go back to the previous song.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $previousTrack = $sonos->getController()->getStateDetails();
        $sonos->getController()->previous();
        $track = $sonos->getController()->getStateDetails();

        $output->writeln("<info>{$previousTrack->title}</info> by <info>{$previousTrack->artist}</info> <error>skipped</error>");
        $output->writeln("<info>Now Playing:</info> <comment>{$track->title}</comment> by <info>{$track->artist}</info>");
    }
}
