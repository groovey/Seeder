<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;

class Tester
{
    private $tester;

    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }

    public function command(Command $command, $name, $input = '')
    {
        $app = new Application();
        $app->add($command);

        $command = $app->find($name);

        $tester = new CommandTester($command);

        if ($input) {
            $helper = $command->getHelper('question');
            $helper->setInputStream($this->getInputStream($input));
        }

        $tester->execute([
                'command' => $command->getName(),
            ]);

        $this->tester = $tester;
    }

    public function getDisplay()
    {
        return $this->tester->getDisplay();
    }
}
