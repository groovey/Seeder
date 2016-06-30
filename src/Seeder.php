<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class Seeder
{
    public $table;
    public $faker;
    public $output;
    public $app;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function inject(OutputInterface $output, $app)
    {
        $this->output = $output;
        $this->app    = $app;
    }

    public function seed($func, $total = 1, $truncate = false)
    {
        $app      = $this->app;
        $progress = new ProgressBar($this->output, $total);

        if ($truncate) {
            $app['db']->table($this->table)->truncate();

            $this->output->writeln('<info>Truncated table.</info>');
        }

        $this->output->writeln('<info>Start seeding.</info>');

        $progress->start();

        $cnt = 0;
        while ($cnt++ < $total) {
            $data = $func($cnt, $this->output);

            $app['db']->table($this->table)->insert(
                $data
            );

            $progress->advance();
        }

        $progress->finish();

        $this->output->writeln("\n<info>End seeding.</info>");
    }
}
