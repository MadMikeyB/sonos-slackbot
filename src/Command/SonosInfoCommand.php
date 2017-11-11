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

        $controllers = $sonos->getControllers();
        foreach ($controllers as $controller) {
            $track = $controller->getStateDetails();
            if ($track->stream) {
                $output->writeln("<info>Currently Streaming:</info> {$track->stream}");
                if ($track->artist) {
                    $output->writeln("<info>Artist:</info> {$track->artist}");
                    $output->writeln("<info>Track:</info> {$track->title}");
                }
            } else {
                $output->writeln("Now Playing: {$track->title} from {$track->album} by {$track->artist}");
                $output->writeln("Running Time: {$track->position} / {$track->duration}");
            }
        }

    }
}
