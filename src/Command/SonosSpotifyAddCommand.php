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
        $this->setDescription('Add a track from Spotify to the queue.');

        $this->addArgument('track-name', InputArgument::REQUIRED, 'The name of the track.');
        $this->addArgument('now', InputArgument::OPTIONAL, 'Play the track immediately.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api = new SpotifyWebAPI;
        $sonos = new Network;
        $session = new Session(
            getenv('SPOTIFY_CLIENT_ID'),
            getenv('SPOTIFY_CLIENT_SECRET')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api->setAccessToken($accessToken);
        $tracks = $api->search($input->getArgument('track-name'), 'track');

        if ($tracks) {
            if ($tracks->tracks->items) {
                $track = $tracks->tracks->items[0];
                if ($input->getArgument('now')) {
                    $track = new Spotify($track->id);
                    $sonos->getController()->useQueue();
                    $sonos->getController()->getQueue()->addTrack($track, 2);
                    $sonos->getController()->interrupt($track, 100);
                } else {
                    $sonos->getController()->getQueue()->addTrack(new Spotify($track->id));
                }

                $output->writeln("<info>{$track->name}</info> by <comment>{$track->artists[0]->name}</comment> added to queue!");
            } else {
                $output->writeln("<error>I couldn't find anything! :(</error>");
            }
        }
    }
}
