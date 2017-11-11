<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosCrossFadeCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:crossfade');
        $this->setDescription('Enable Crossfade.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controllers = $sonos->getControllers();
        foreach ($controllers as $controller) {
            if (!$controller->getCrossfade()) {
                $controller->setCrossfade(true);
                $output->writeln("Crossfade enabled for {$controller->room}");
            } else {
                $controller->setCrossfade(false);
                $output->writeln("Crossfade disabled for {$controller->room}");
            }
        }

    }
}


