<?php

class Users extends Seeder
{
    public $table = 'users';

    public function run()
    {
        $faker = $this->faker;

        $this->seed(function ($counter, $output) use ($faker) {

            $faker->seed($counter);
            $status = ['ACTIVE', 'INACTIVE'];

            return [
                'status' => $status[array_rand($status)],
                'name' => $faker->name,
                'email' => $faker->email,
                'created_at' => $faker->dateTimeThisMonth(),
            ];

        }, 100, $truncate = true);

        return;
    }
}
