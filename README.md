Groovey Seeder
==============

A simple database seeder class with progress bar. Auto populates your database with fake records instantly. Less coding required, just filling your database field values. Currently supports four database system Mysql, Postgress, SQLite and SQL servers.

## Usage

    $ groovey seed:run Test

## See It In Action

![alt tag](https://raw.githubusercontent.com/groovey/Seeder/master/groovey.jpg)


## Step 1 - Installation

Install using composer. To learn more about composer, visit: https://getcomposer.org/

     $ composer requre groovey/seeder 

Then run `composer.phar` update.


## Step 2 - The Groovey File

On your project root folder. Create a file called `groovey`.

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

$db = [
        'dbname'   => 'test',
        'user'     => 'root',
        'password' => 'webdevel',
        'host'     => 'localhost',
        'driver'   => 'pdo_mysql',
    ];

$config = new Configuration();
$conn   = DriverManager::getConnection($db, $config);
$app    = new Application();

$container['db'] = $conn;

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

Here is a sample working seeder class.

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
                'created_at' => $faker->date('Y-m-d H-m-s', 'now')
            ];

        }, 100, $truncate = true);

        return;
    }
}
```

## Like Us.

Give a `star` to show your support and love for the project.

## Contribution

Fork `Groovey Seeder` and send us some issues.
