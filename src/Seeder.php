<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class Seeder extends Factory
{
    public $faker;
    public $output;
    public $app;
    public $total;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('en_US');
    }

    public function inject(OutputInterface $output, $app, $total = 1)
    {
        $this->output = $output;
        $this->app    = $app;
        $this->total  = $total;
    }

    public function seed($func)
    {
        $app      = $this->app;
        $total    = $this->total;
        $output   = $this->output;
        $progress = new ProgressBar($output, $total);

        $this->truncate($output, $app);

        $this->output->writeln('<info>Start seeding.</info>');

        $progress->start();

        $counter = 0;
        while ($counter++ < $total) {
            $data = $func($counter);

            $progress->advance();
        }

        $progress->finish();

        $this->output->writeln("\n<info>End seeding.</info>");
    }
}
