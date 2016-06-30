# Groovey Seeder

A simple database seeder class with progress bar.

## Usage

    $ groovey seed:run Test

## See It In Action

![alt tag](https://raw.githubusercontent.com/groovey/Seeder/master/groovey.jpg)


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
    'database'  => 'test',
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
    public $table = 'test';

    public function run()
    {
        $faker = $this->faker;

        $this->seed(function ($counter, $output) use ($faker) {

            $faker->seed($counter);

            return [
                'name' => $faker->name,
                'email' => $faker->email,
                'created_at' => $faker->dateTimeThisMonth(),
            ];

        }, 100, $truncate = true);

        return;
    }
}

```
