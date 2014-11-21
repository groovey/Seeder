<?php namespace Groovey\Seeder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class About extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('seed:about')
            ->setDescription('Shows credits to the author.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

$about = <<<ABOUT
 <comment>
    ______
   / ____/________  ____ _   _____  __  __
  / / __/ ___/ __ \/ __ \ | / / _ \/ / / /
 / /_/ / /  / /_/ / /_/ / |/ /  __/ /_/ /
 \____/_/   \____/\____/|___/\___/\__, /
                                 /____/
 </comment>
 Project Name: Groovey Seeder
 Git: https://github.com/groovey/seeder
 Author: Harold Kim Cantil <pokoot@gmail.com>

 Crafted with love.

ABOUT;

        $output->writeln($about);
    }

}
