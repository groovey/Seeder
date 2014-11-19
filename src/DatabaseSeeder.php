<?php namespace Groovey\Seeder;

class DatabaseSeeder
{

    public function __construct()
    {
    }

    public function getCommands()
    {
        return [
            new Commands\Init(),
            new Commands\Run(),
            new Commands\Create(),
            new Commands\About()
        ];
    }

}
