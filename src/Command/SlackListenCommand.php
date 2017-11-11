<?php
namespace MadMikeyB\SonosBot\Command;

use Illuminate\Support\Str;
use React\EventLoop\Factory;
use Slack\Channel;
use Slack\RealTimeClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use duncan3dc\Sonos\Network;

class SlackListenCommand extends Command
{
    protected function configure()
    {
        $this->setName('slack:listen');
        $this->setDescription('Listen to Slack and perform actions based on user input.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();

        $client = new RealTimeClient($loop);
        $client->setToken(getenv('SLACK_BOT_TOKEN'));

        $client->connect()->then(function () {
            echo "Connected!\n";
        });

        $client->on('message', function ($data) use ($client) {
            if (Str::contains($data['text'], 'add')) {
                $this->processAddCommand($client, $data);
            }
        });

        $loop->run();
    }

    protected function processAddCommand($client, $data)
    {
        $command = $this->getApplication()->find('sonos:spotify:add');

        $trackName = trim(explode('add', $data['text'])[1]);

        $arguments = array(
            'command' => 'sonos:spotify:add',
            'track-name' => $trackName,
        );

        $input = new ArrayInput($arguments);
        $output = new BufferedOutput();
        $command->run($input, $output);

        $client->getChannelById($data['channel'])->then(function (\Slack\Channel $channel) use ($client, $output) {
            $content = $output->fetch();
            $client->send($content, $channel);
        });
    }
}


