<?php

use Illuminate\Database\Capsule\Manager as DB;

class Database
{
    public static function create()
    {
        $exist = DB::schema()->hasTable('users');

        if ($exist) {
            DB::schema()->drop('users');
        }

        DB::schema()->create('users', function ($table) {
            $table->enum('status', ['active', 'inactive']);
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    public static function drop()
    {
        DB::schema()->drop('users');
    }
}
