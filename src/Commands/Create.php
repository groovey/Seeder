<?php

namespace Groovey\Seeder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;

class Create extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('seed:create')
            ->setDescription('Creates a template.')
            ->addArgument(
                'class',
                InputArgument::REQUIRED,
                'The class name to be created.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $class = $input->getArgument('class');
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../Template/');
        $twig = new \Twig_Environment($loader);
        $fs = new Filesystem();
        $dir = getcwd().'/database/seeds';
        $file = $dir.'/'.ucfirst($class).'.php';
        $helper = $this->getHelper('question');

        if (!$fs->exists($dir)) {
            $output->writeln('<error>The seeds directory does not exist. Make sure you run groovey seed:init first.</error>');

            return;
        }

        if ($fs->exists($file)) {
            $question = new ConfirmationQuestion(
                '<question>The seeder file already exist, are you sure you want to replace it? (Y/N):</question> ',
                 false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        $contents = $twig->render('template.twig', [
            'class' => ucfirst($class),
            'table' => strtolower($class),
        ]);

        file_put_contents($file, $contents);

        $text = '<info>Sucessfully created seed directory.</info>';
        $output->writeln($text);
    }
}
