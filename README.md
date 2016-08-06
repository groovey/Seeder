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

use Symfony\Component\Console\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'test_seeder',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
], 'default');

$capsule->bootEloquent();
$capsule->setAsGlobal();

$container['db'] = $capsule;

$app = new Application();

$app->addCommands([
        new Groovey\Seeder\Commands\About(),
        new Groovey\Seeder\Commands\Init($container),
        new Groovey\Seeder\Commands\Create($container),
        new Groovey\Seeder\Commands\Run($container),
    ]);

$status = $app->run();

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