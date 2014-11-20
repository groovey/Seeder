Groovey Seeder
==============

A simple database seeder class with progress bar. Auto populates your database with fake records instantly. Less coding required, just filling your database field values. Currently supports four database system Mysql, Postgress, SQLite and SQL servers.

## Usage

    $ groovey seed:run Test

## See It In Action

![alt tag](https://raw.githubusercontent.com/groovey/Seeder/master/groovey.jpg)


## Installation

Install using composer. To learn more about composer, visit: https://getcomposer.org/

```json
{
    "require": {
        "groovey/seeder": "~1.0"
    }
}
```

Then run `composer.phar` update.


## The Groovey File

On your project root folder. Create a file called `groovey`. Or this could be any project name like `awesome`. Then  paste the code below.

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database.php';

use Symfony\Component\Console\Application;
use Groovey\Seeder\DatabaseSeeder;

$seeder  = new DatabaseSeeder();
$app     = new Application;

$app->addCommands(
        $seeder->getCommands()
    );

$status = $app->run();

exit($status);
```

## The Database Bootstrap File

Change the default parameters of the database to your environment settings.

```php
<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'groovey',
    'username'  => 'root',
    'password'  => 'awesome',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
], 'default');

$capsule->bootEloquent();
$capsule->setAsGlobal();

return $capsule;
```

Great! Spam your database now.

## Init

Setup your seeder directory relative to your root folder `./database/seeds`.

    $ groovey seed:Init

## Create

Automatically creates a sample seeder class.

    $ groovey seed:create Test

## Run

Runs the seeder class

    $ groovey seed:run Test

And yes! it only takes 3 commands to master the `groovey seeder`.


## Seeder Class

Here is a sample working seeder class.

```php
<?php

class Test extends Seeder {

    public $table = 'test';

    public function run()
    {

        $faker = $this->faker;

        $this->seed(function ($counter, $output) use ($faker) {

            $faker->seed($counter);

            return [
                'name'       => $faker->name,
                'email'      => $faker->email,
                'created_at' => $faker->dateTimeThisMonth()
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