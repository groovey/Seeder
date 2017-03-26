# Seeder

Groovey Seeder Package

## Usage

    $ groovey seed:run Test

## Installation

    $ composer require groovey/seeder

## Setup

On your project root folder. Create a file called `groovey`.

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

require_once __DIR__.'/vendor/autoload.php';

use Silex\Application;
use Groovey\Console\Providers\ConsoleServiceProvider;
use Groovey\DB\Providers\DBServiceProvider;

$app = new Application();

$app->register(new ConsoleServiceProvider(), [
        'console.name'    => 'Groovey',
        'console.version' => '1.0.0',
    ]);

$app->register(new DBServiceProvider(), [
        'db.connection' => [
            'host'      => 'localhost',
            'driver'    => 'mysql',
            'database'  => 'test_seeder',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'logging'   => true,
        ],
    ]);

$console = $app['console'];

$console->addCommands([
        new Groovey\Seeder\Commands\About(),
        new Groovey\Seeder\Commands\Init($app),
        new Groovey\Seeder\Commands\Create($app),
        new Groovey\Seeder\Commands\Run($app),
        new Groovey\Migration\Commands\About(),
        new Groovey\Migration\Commands\Init($app),
        new Groovey\Migration\Commands\Reset($app),
        new Groovey\Migration\Commands\Listing($app),
        new Groovey\Migration\Commands\Drop($app),
        new Groovey\Migration\Commands\Status($app),
        new Groovey\Migration\Commands\Create($app),
        new Groovey\Migration\Commands\Up($app),
        new Groovey\Migration\Commands\Down($app),
    ]);

$status = $console->run();

exit($status);
```

Great! Spam your database now.

## Init

Setup your seeder directory relative to your root folder `./database/seeds`.

    $ groovey seed:init

## Create

Automatically creates a sample seeder class.

    $ groovey seed:create Test

## Create Test Database

* Define your mysql test table
* Edit your `Test` class

## Run

Runs the seeder class

    $ groovey seed:run Test

## Seeder Class

A sample working seeder class.

```php
<?php

class Test extends Seeder
{
    public function init()
    {
        $faker = $this->faker;

        $this->define('users', function () use ($faker) {
            return [
                'name' => $faker->name,
            ];
        }, $truncate = true);

    }

    public function run()
    {
        $this->seed(function ($counter){
            $this->factory('users')->create();
        });

        return;
    }
}
```