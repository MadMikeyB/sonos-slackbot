<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosPlaylistsCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:playlist');
        $this->setDescription('Get stored SONOS playlists, see information about them and play them');

        $this->addArgument('playlist-name', InputArgument::OPTIONAL, 'The name of the playlist.');
        $this->addArgument('play', InputArgument::OPTIONAL, 'Play the selected playlist.');
        $this->addArgument('now', InputArgument::OPTIONAL, 'Play the selected playlist immediately... rather than wait for the queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;
        if ($input->getArgument('playlist-name')) {
            $playlist = $sonos->getPlaylistByName($input->getArgument('playlist-name'));

            foreach ($playlist->getTracks() as $track) {
                if ($input->getArgument('play')) {
                    $sonos->getController()->getQueue()->addTrack($track);
                    if ($input->getArgument('now')) {
                        $sonos->getController()->useQueue();
                    }
                } else {
                    $output->writeln("* <info>{$track->title}</info> - <comment>{$track->artist}</comment>");
                }
            }

            if (!$input->getArgument('play')) {
                $output->writeln('');
                $output->writeln("<fg=black;options=bold>php sonosbot sonos:playlist \"{$playlist->getName()}\" play</> to play.");
            } else {
                $output->writeln("<info>{$playlist->getName()}</info> added to queue");
                if ($input->getArgument('now')) {
                    $sonos->getController()->play();
                    $output->writeln("<info>{$playlist->getName()}</info> now playing...");
                }
            }
        } else {
            $playlists = $sonos->getPlaylists();
            foreach ($playlists as $playlist) {
                $count = count($playlist);
                $output->writeln("<info>{$playlist->getName()}</info> - <comment>{$count} tracks</comment>");
                $output->writeln(" <fg=black;options=bold>php sonosbot sonos:playlist \"{$playlist->getName()}\"</> for more info.");
            }
        }
    }
}
