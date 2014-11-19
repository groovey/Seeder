<?php
/*
| -------------------------------------------------------------------
| Testing faker components
| -------------------------------------------------------------------
*/
require "../vendor/autoload.php";

// require_once '../Faker/src/autoload.php';

$faker = Faker\Factory::create();
 $faker->seed(1);
echo $faker->name;