<?php

use Silex\Application;
use Groovey\DB\Providers\DBServiceProvider;
use Groovey\Tester\Providers\TesterServiceProvider;
use Groovey\Seeder\Commands\Init as SeederInit;
use Groovey\Seeder\Commands\About;
use Groovey\Seeder\Commands\Run;
use Groovey\Migration\Commands\Init as MigrationInit;
use Groovey\Migration\Commands\Status;
use Groovey\Migration\Commands\Up;
use Groovey\Migration\Commands\Down;
use Groovey\Migration\Commands\Drop;

class SeederTest extends PHPUnit_Framework_TestCase
{
    public $app;

    public function setUp()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new TesterServiceProvider());

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

        $app['tester']->add([
                new MigrationInit($app),
                new Status($app),
                new Up($app),
                new SeederInit($app),
                new About(),
                new Run($app),
                new Down($app),
                new Drop($app),
            ]);

        $this->app = $app;
    }

    /**
     * -------------------------------------------------------------------------
     * Migration - Start
     * -------------------------------------------------------------------------.
     */
    public function testMigrationInit()
    {
        $app = $this->app;
        $display = $app['tester']->command('migrate:init')->execute()->display();
        $this->assertRegExp('/Sucessfully/', $display);
    }

    public function testMigrationStatus()
    {
        $app = $this->app;
        $display = $app['tester']->command('migrate:status')->execute()->display();
        $this->assertRegExp('/001/', $display);
        $this->assertRegExp('/002/', $display);
    }

    public function testMigrationUp()
    {
        $app = $this->app;
        $display = $app['tester']->command('migrate:up')->input('Y\n')->execute()->display();
        $this->assertRegExp('/001/', $display);
        $this->assertRegExp('/002/', $display);
    }

    public function testSeederAbout()
    {
        $app = $this->app;
        $display = $app['tester']->command('seed:about')->execute()->display();
        $this->assertRegExp('/Groovey/', $display);
    }

    /**
     * -------------------------------------------------------------------------
     * Seeder
     * -------------------------------------------------------------------------.
     */
    public function testSeederInit()
    {
        $app = $this->app;
        $display = $app['tester']->command('seed:init')->execute()->display();
        $this->assertRegExp('/Sucessfully/', $display);
    }

    public function testSeederRun()
    {
        $app = $this->app;
        $display = $app['tester']->command('seed:run')->input('Y\n')->execute(['class' => 'UsersPosts', 'total' => 5])->display();
        $this->assertRegExp('/End seeding/', $display);
    }

    /**
     * -------------------------------------------------------------------------
     * Migration - End
     * -------------------------------------------------------------------------.
     */
    public function testMigrationDown()
    {
        $app = $this->app;
        $display = $app['tester']->command('migrate:down')->input('Y\n')->execute(['version' => '001'])->display();
        $this->assertRegExp('/001/', $display);
        $this->assertRegExp('/002/', $display);
    }

    public function testMigrationDrop()
    {
        $app = $this->app;
        $display = $app['tester']->command('migrate:drop')->input('Y\n')->execute()->display();
        $this->assertRegExp('/Migrations table has been deleted/', $display);
    }
}
