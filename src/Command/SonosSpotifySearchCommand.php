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

class SonosSpotifySearchCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:spotify:search');
        $this->setDescription('Search Spotify for a track');

        $this->addArgument('track-name', InputArgument::REQUIRED, 'The name of the track.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api = new SpotifyWebAPI;
        $sonos = new Network;

        $api->setAccessToken(getenv('SPOTIFY_ACCESS_TOKEN'));
        $tracks = json_decode(json_encode($api->search($input->getArgument('track-name'), 'track')), true)['tracks']['items'];

        if ($tracks) {
            $output->writeln("<comment>I found the following tracks:</comment>");
            foreach ($tracks as $track) {
                $output->writeln("* <info>{$track['name']}</info> by <comment>{$track['artists'][0]['name']}</comment>");
            }
        } else {
            $output->writeln("<info>I couldn't find anything for that. :(</info>");
        }

        // if ($tracks) {
        //     $track = $tracks->tracks->items[0];
        //     $sonos->getController()->getQueue()->addTrack(new Spotify($track->id));

        //     $output->writeln("<info>{$track->name}</info> by <comment>{$track->artists[0]->name}</comment> added to queue!");
        // }
    }
}
