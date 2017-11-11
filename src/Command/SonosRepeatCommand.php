<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosRepeatCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:repeat');
        $this->setDescription('Repeat the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controller = $sonos->getController();

        if (!$controller->getRepeat()) {
            $controller->setRepeat(true);
            $output->writeln("Enabling Repeat on {$controller->room}");
        } else {
            $controller->setRepeat(false);
            $output->writeln("Disabling Repeat on {$controller->room}");
        }
    }
}
