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
        if ($track->stream) {
            $output->writeln("<info>Currently Streaming:</info> {$track->stream}");
            if ($track->artist) {
                $output->writeln("<info>Artist:</info> {$track->artist}");
                $output->writeln("<info>Track:</info> {$track->title}");
                $output->writeln("<info>Running Time:</info> {$track->position} / {$track->duration}");
            }
        } else {
            $output->writeln("<info>Now Playing:</info> {$track->title} from {$track->album} by {$track->artist}");
            $output->writeln("<info>Running Time:</info> {$track->position} / {$track->duration}");
        }
    }
}
