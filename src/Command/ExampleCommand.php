<?php
namespace MadMikeyB\SonosBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    protected function configure()
    {
        $this->setName('example');
        $this->setDescription('Example Command');

        $this->addArgument('author', InputArgument::REQUIRED);
        $this->addArgument('year', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $output->writeln("{$input->getArgument('author')} created this in {$input->getArgument('year')}");
    }
}
