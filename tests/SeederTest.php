<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Groovey\Seeder\Commands\About;
use Groovey\Seeder\Commands\Init;
use Groovey\Seeder\Commands\Run;
use Groovey\Migration\Commands\Init as MigrationInit;
use Groovey\Migration\Commands\Status;
use Groovey\Migration\Commands\Up;
use Groovey\Migration\Commands\Down;
use Groovey\Migration\Commands\Drop;

class SeederTest extends PHPUnit_Framework_TestCase
{
    public $db;

    public function setUp()
    {
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

        $this->db = $capsule;
    }

    /**
     * -------------------------------------------------------------------------
     * Migration Start
     * -------------------------------------------------------------------------.
     */
    public function testMigrationInit()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new MigrationInit($container), 'migrate:init');
        $this->assertRegExp('/Sucessfully/', $tester->getDisplay());
    }

    public function testMigrationStatus()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new Status($container), 'migrate:status');
        $this->assertRegExp('/Unmigrated SQL/', $tester->getDisplay());
        $this->assertRegExp('/001_create_users.yml/', $tester->getDisplay());
        $this->assertRegExp('/002_create_posts.yml/', $tester->getDisplay());
    }

    public function testMigrationUp()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new Up($container), 'migrate:up');

        $this->assertRegExp('/Running migration file/', $tester->getDisplay());
    }

    /**
     * -------------------------------------------------------------------------
     * Seeder Test
     * -------------------------------------------------------------------------.
     */
    public function testSeederAbout()
    {
        $tester = new Tester();
        $tester->command(new About(), 'seed:about');
        $this->assertRegExp('/Groovey/', $tester->getDisplay());
    }

    public function testSeederInit()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new Init($container), 'seed:init');
        $this->assertRegExp('/Sucessfully/', $tester->getDisplay());
    }

    public function testSeederRun()
    {
        $container['db'] = $this->db;

        $app = new Application();
        $app->add(new Run($container));
        $command = $app->find('seed:run');
        $tester = new CommandTester($command);

        $tester->execute([
                'command' => $command->getName(),
                'class'   => 'UsersPost',
                'total'   => 5,
            ]);

        $this->assertRegExp('/End seeding/', $tester->getDisplay());
    }

    /**
     * -------------------------------------------------------------------------
     * Migration End
     * -------------------------------------------------------------------------.
     */
    public function testMigrationDown()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new Down($container), 'migrate:down', 'Y\n');
        $this->assertRegExp('/Downgrading migration file/', $tester->getDisplay());

        $tester->command(new Down($container), 'migrate:down', 'Y\n');
        $this->assertRegExp('/Downgrading migration file/', $tester->getDisplay());
    }

    public function testMigrationDrop()
    {
        $container['db'] = $this->db;

        $tester = new Tester();
        $tester->command(new Drop($container), 'migrate:drop', 'Y\n');
        $this->assertRegExp('/Migrations table has been deleted/', $tester->getDisplay());
    }
}
