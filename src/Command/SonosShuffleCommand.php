<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosShuffleCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:shuffle');
        $this->setDescription('Shuffle the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controller = $sonos->getController();
        if (!$controller->getShuffle()) {
            $controller->setShuffle(true);
            $output->writeln("Enabling Shuffle on {$controller->room}");
        } else {
            $controller->setShuffle(false);
            $output->writeln("Disabling Shuffle on {$controller->room}");
        }
    }
}
