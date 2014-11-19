<?php namespace Groovey\Seeder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Yaml\Parser;
use Illuminate\Database\Capsule\Manager as DB;
use Groovey\Seeder\Adapters\Adapter;
use Groovey\Migration\Manager;
use Symfony\Component\Console\Helper\ProgressBar;

class Run extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('seed:run')
            ->setDescription('Runs the seeder.')
            ->addArgument(
                'class',
                InputArgument::REQUIRED,
                'Runs the class task.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $fs       = new Filesystem();
        $class    = $input->getArgument('class');
        $filename = getcwd() . "/database/seeds/{$class}.php";

        if (!$fs->exists($filename)) {
            $output->writeln("<info>The seeder class does not exits.</info>");
            return;
        }

        include_once __DIR__ . '/../Seeder.php';
        include_once $filename;

        $instance = new $class();

        $instance->inject($output);
        $instance->run();
    }

}
