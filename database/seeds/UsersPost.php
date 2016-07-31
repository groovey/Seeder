<?php

class UsersPost extends Seeder
{
    public function init()
    {
        $faker = $this->faker;

        $this->define('users', function () use ($faker) {
            return [
                'name' => $faker->name,
            ];
        }, $truncate = true);

        $this->define('posts', function ($fk) use ($faker) {
            return [
                'user_id' => $fk->user_id,
                'title'   => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'content' => $faker->realText(500),
            ];
        }, $truncate = true);
    }

    public function run()
    {
        $this->seed(function ($counter){

            $user_id = $this->factory('users')->create();
            $fk      = ['user_id' => $user_id];
            $random  = rand(1,10);

            for ($i=0; $i < $random; $i++) {
                $this->factory('posts')->create($fk);
            }
        });

        return;
    }
}
