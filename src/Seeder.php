<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Capsule\Manager as DB;

class Seeder
{
    public $table;
    public $faker;
    public $output;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function inject(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function seed($func, $total = 1, $truncate = false)
    {
        $progress = new ProgressBar($this->output, $total);

        if ($truncate) {
            DB::table($this->table)->truncate();
            $this->output->writeln('<info>Truncated table.</info>');
        }

        $this->output->writeln('<info>Start seeding.</info>');

        $progress->start();

        $cnt = 0;
        while ($cnt++ < $total) {
            $obj = $func($cnt, $this->output);

            DB::table($this->table)->insert(
                $obj
            );

            $progress->advance();
        }

        $progress->finish();

        $this->output->writeln("\n<info>End seeding.</info>");
    }
}
