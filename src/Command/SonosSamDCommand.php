<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;
use duncan3dc\Sonos\Tracks\Spotify;

class SonosSamDCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:crossroads');
        $this->setDescription('Play Crossroads by Blazin\' Squad');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controller = $sonos->getController();
        $track = new Spotify("4IEOKcFZGMiKp5NXYjH001");
        $controller->useQueue();
        $controller->getQueue()->addTrack($track, 1);
        $controller->selectTrack(1);
        $controller->play();
    }
}
