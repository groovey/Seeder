<?php

namespace Groovey\Seeder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Groovey\Support\Output;

class Create extends Command
{
    private $app;

    public function __construct($app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('seed:create')
            ->setDescription('Creates a seeder class template.')
            ->addArgument(
                'class',
                InputArgument::REQUIRED,
                'The class name to be created.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $class  = $input->getArgument('class');
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../Templates/');
        $twig   = new \Twig_Environment($loader);
        $fs     = new Filesystem();
        $output = Output::style($output);
        $dir    = getcwd().'/database/seeds';
        $file   = $dir.'/'.ucfirst($class).'.php';
        $helper = $this->getHelper('question');

        if (!$fs->exists($dir)) {
            $output->writeln('<error>The seeder directory does not exist. Make sure you run groovey seed:init first.</error>');

            return;
        }

        $output->writeln('<highlight>Creating seeder file:</highlight>');
        $output->writeln("<info>- $file</info>");

        if ($fs->exists($file)) {
            $question = new ConfirmationQuestion(
                '<question>The seeder file already exist. Are you sure you want to replace it? (Y/N):</question> ',
                 false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        } else {
            $question = new ConfirmationQuestion('<question>Are you sure you want to proceed? (Y/n):</question> ', false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        $contents = $twig->render('seeder.twig', [
            'class' => ucfirst($class),
            'table' => strtolower($class),
        ]);

        file_put_contents($file, $contents);

        $output->writeln('<info>Sucessfully created seed file.</info>');
    }
}
