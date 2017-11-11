<?php
namespace MadMikeyB\SonosBot\Command;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;
use duncan3dc\Sonos\Tracks\Spotify;

class SonosSpotifyAddCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:spotify:add');
        $this->setDescription('Search Spotify for a track');

        $this->addArgument('track-name', InputArgument::REQUIRED, 'The name of the track.');
        $this->addArgument('now', InputArgument::OPTIONAL, 'Play the track immediately.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api = new SpotifyWebAPI;
        $sonos = new Network;

        $api->setAccessToken(getenv('SPOTIFY_ACCESS_TOKEN'));
        $tracks = $api->search($input->getArgument('track-name'), 'track');

        if ($tracks) {
            $track = $tracks->tracks->items[0];
            if ($input->getArgument('now')) {
                $sonos->getController()->useQueue();
                $sonos->getController()->getQueue()->addTrack(new Spotify($track->id), 2);
                $sonos->getController()->pause();
                $sonos->getController()->selectTrack(1)->play();
            } else {
                $sonos->getController()->useQueue();
                $sonos->getController()->getQueue()->addTrack(new Spotify($track->id));
            }

            $output->writeln("<info>{$track->name}</info> by <comment>{$track->artists[0]->name}</comment> added to queue!");
        }
    }
}
