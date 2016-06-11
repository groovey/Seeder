<?php

namespace Groovey\Seeder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Init extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('seed:init')
            ->setDescription('Setup your database/seeds directory.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $folder = getcwd().'/database/seeds';

        try {
            $fs->mkdir($folder, 755);
        } catch (IOExceptionInterface $e) {
            $output->writeln("<error>An error occurred while creating your directory at {$e->getPath()}</error>");

            return;
        }

        if (file_exists($folder) && is_dir($folder)) {
            $output->writeln("<comment>Place all your seeder files in ($folder)</comment>");
        }

        $output->writeln('<info>Sucessfully created seeder folder.</info>');
    }
}
