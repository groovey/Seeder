<?php namespace Groovey\Seeder\Commands;

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

        $class  = $input->getArgument('class');
        $loader = new \Twig_Loader_Filesystem(__DIR__. '/../Template/');
        $twig   = new \Twig_Environment($loader);
        $fs     = new Filesystem();

        $contents = $twig->render('template.twig', [
            'class' => ucfirst($class),
            'table' => strtolower($class)
        ]);

        $file = getcwd() . '/database/seeds/' . ucfirst($class) . '.php';

        if ($fs->exists($file)) {

            $helper = $this->getHelper('question');

            $question = new ConfirmationQuestion(
                '<question>The seeder file already exist, are you sure you want to replace it? (Y/N):</question> ',
                 false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        file_put_contents($file, $contents);

        $text = '<info>Sucessfully created seed file.</info>';
        $output->writeln($text);
    }

}
