<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SonosStopCommand extends Command
{
    protected function configure()
    {
        $this->setName('sonos:stop');
        $this->setDescription('Stop the current queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonos = new Network;

        $sonos->getController()->getQueue()->clear();
        $output->writeln("Music stopped on {$sonos->getController()->room}");
    }
}
