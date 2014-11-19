<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'groovey',
    'username'  => 'root',
    'password'  => '1234567890',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
], 'default');

$capsule->bootEloquent();
$capsule->setAsGlobal();

return $capsule;