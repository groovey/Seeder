<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'seeder',
    'username'  => 'root',
    'password'  => 'webdevel',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
], 'default');

$capsule->bootEloquent();
$capsule->setAsGlobal();

return $capsule;