<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosPlayCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:play');
        $this->setDescription('Play the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $controllers = $sonos->getControllers();
        foreach ($controllers as $controller) {
            $output->writeln("Now playing on {$controller->room}");
            $controller->play();
        }

    }
}
