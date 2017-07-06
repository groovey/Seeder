<?php

class UsersPosts extends Seeder
{
    public function init()
    {
        $faker = $this->faker;

        $this->define('users', function () use ($faker) {
            return [
                'name' => $faker->name,
            ];
        }, $truncate = true);

        $this->define('posts', function ($data) use ($faker) {
            return [
                'user_id' => $data->user_id,
                'title'   => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'content' => $faker->realText(500),
            ];
        }, $truncate = true);
    }

    public function run()
    {
        $this->seed(function ($counter) {

            $userId = $this->factory('users')->create();
            $data   = ['user_id' => $userId];
            $random = rand(1, 10);

            for ($i = 0; $i < $random; ++$i) {
                $this->factory('posts')->create($data);
            }
        });
    }
}
