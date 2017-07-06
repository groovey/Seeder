<?php

class Sample extends Seeder
{
    public function init()
    {
        $faker = $this->faker;

        $this->define('sample', function ($data) use ($faker) {
            return [
                'name' => $faker->name,
            ];
        }, $truncate = true);
    }

    public function run()
    {
        $this->seed(function ($counter) {

            $this->output->writeln("Counter =  $counter");
            $this->factory('sample')->create();
        });
    }
}
