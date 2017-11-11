<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosPauseCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:pause');
        $this->setDescription('Pause the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controllers = $sonos->getControllers();
        foreach ($controllers as $controller) {
            $output->writeln("Pausing music on {$controller->room}");
            $controller->pause();
        }

    }
}
