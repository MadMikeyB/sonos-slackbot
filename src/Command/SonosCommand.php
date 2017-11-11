<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:network');
        $this->setDescription('Get the SONOS Network Information');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controllers = $sonos->getControllers();
        foreach ($controllers as $controller) {
            $output->writeln("{$controller->room} is the SONOS Controller, and it is currently {$controller->getStateName()}");
        }

        $speakers = $sonos->getSpeakers();
        foreach ($speakers as $speaker) {
            if ($speaker->getVolume() > 50) {
                $output->writeln("<error>LOUD</error>: <info>{$speaker->room} is controlled by {$speaker->name} and is currently set to {$speaker->getVolume()} dB </info>");
            } else {
                $output->writeln("<info>{$speaker->room} is controlled by {$speaker->name} and is currently set to {$speaker->getVolume()} dB </info>");
            }
        }


    }
}
