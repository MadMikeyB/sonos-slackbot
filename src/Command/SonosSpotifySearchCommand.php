<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosSpotifySearchCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:spotify:search');
        $this->setDescription('Search Spotify for a track');

        $this->addArgument('track-name', InputArgument::REQUIRED, 'The name of the track.');
        $this->addArgument('artist-name', InputArgument::REQUIRED, 'The name of the artist.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $session = new SpotifyWebAPI\Session(
            'CLIENT_ID',
            'CLIENT_SECRET'
        );
    }
}
