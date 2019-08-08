<?php
namespace MadMikeyB\SonosBot\Command;

use Slack\Channel;
use Slack\RealTimeClient;
use duncan3dc\Sonos\Network;
use Illuminate\Support\Str;
use React\EventLoop\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

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
            if (Str::contains($data['text'], 'current')) {
                $this->processCommand($client, $data, 'sonos:info');
            }
            if (Str::contains($data['text'], 'next')) {
                $this->processCommand($client, $data, 'sonos:next');
            }
            if (Str::contains($data['text'], 'prev')) {
                $this->processCommand($client, $data, 'sonos:prev');
            }
            if (Str::contains($data['text'], 'pause')) {
                $this->processCommand($client, $data, 'sonos:pause');
            }
            if (Str::contains($data['text'], 'stop')) {
                $this->processCommand($client, $data, 'sonos:stop');
            }
            if (Str::contains($data['text'], 'play')) {
                $this->processCommand($client, $data, 'sonos:play');
            }
            if (Str::contains($data['text'], 'play')) {
                $this->processCommand($client, $data, 'sonos:play');
            }
            if (Str::contains($data['text'], 'playlist')) {
                $this->processCommand($client, $data, 'sonos:playlist');
            }
            if (Str::contains($data['text'], 'shuffle')) {
                $this->processCommand($client, $data, 'sonos:shuffle');
            }
            if (Str::contains($data['text'], 'repeat')) {
                $this->processCommand($client, $data, 'sonos:repeat');
            }
            if (Str::contains($data['text'], 'crossroads')) {
                $this->processCommand($client, $data, 'sonos:crossroads');
            }
            if (Str::contains($data['text'], 'list')) {
                $this->processCommand($client, $data, 'list');
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

    protected function processCommand($client, $data, $commandName, $args = [])
    {
        $command = $this->getApplication()->find($commandName);

        $arguments = array(
            'command' => $commandName,
            $args
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
