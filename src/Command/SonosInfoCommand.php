<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosInfoCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:info');
        $this->setDescription('Get information on the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controller = $sonos->getController();

        $track = $controller->getStateDetails();
        if ($track->getStream()) {
            $output->writeln("<info>Currently Streaming:</info> {$track->getStream()}");
            if ($track->getArtist()) {
                $output->writeln("<info>Artist:</info> {$track->getArtist()}");
                $output->writeln("<info>Track:</info> {$track->getTitle()}");
                $output->writeln("<info>Running Time:</info> {$track->getPosition()} / {$track->getDuration()}");
            }
        } else {
            $output->writeln("<info>Now Playing:</info> {$track->getTitle()} from {$track->getAlbum()} by {$track->getArtist()}");
            $output->writeln("<info>Running Time:</info> {$track->getPosition()} / {$track->getDuration()}");
        }
    }
}
