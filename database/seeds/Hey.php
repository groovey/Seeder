<?php

class Hey extends Seeder
{
    public function init()
    {
        $faker = $this->faker;

        $this->define('hey', function ($data) use ($faker) {
            return [
                'name' => $faker->name,
            ];
        }, $truncate = true);
    }

    public function run()
    {
        $this->seed(function ($counter){
            $this->factory('hey')->create();
        });
    }
}