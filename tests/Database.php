<?php

class Database
{
    public static function create($app)
    {
        $app['tester']->command('migrate:init')->execute()->display();
        $app['tester']->command('migrate:reset')->input('Y\n')->execute()->display();
        $app['tester']->command('migrate:up')->input('Y\n')->execute()->display();
    }

    public static function drop($app)
    {
        $app['tester']->command('migrate:down')->input('Y\n')->execute(['version' => '0.0.1'])->display();
        $app['tester']->command('migrate:drop')->input('Y\n')->execute()->display();
    }
}
