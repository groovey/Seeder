<?php

use Symfony\Component\Console\Output\OutputInterface;

class Factory
{
    public $factories;
    public $selected;

    public function define($name, $func, $truncate = false, $table = '')
    {
        $this->factories[$name] = [
                'name'     => $name,
                'function' => $func,
                'truncate' => $truncate,
                'table'    => $table,
            ];
    }

    public function factory($name)
    {
        $this->selected = $this->factories[$name];

        return $this;
    }

    public function create(array $fk = [])
    {
        $app      = $this->app;
        $output   = $this->output;
        $factory  = $this->selected;
        $name     = element('name', $factory);
        $table    = element('table', $factory, $name);
        $truncate = element('truncate', $factory);
        $func     = element('function', $factory);
        $data     = $func((object) $fk);

        return $app['db']->table($table)->insertGetId(
                $data
            );
    }

    public function truncate(OutputInterface $output, $app)
    {
        $factories = $this->factories;

        foreach ($factories as $factory) {
            $name     = element('name', $factory);
            $table    = element('table', $factory, $name);
            $truncate = element('truncate', $factory);

            if ($truncate) {
                $app['db']->table($table)->truncate();

                $output->writeln("<info>Truncated table ($table).</info>");
            }
        }
    }
}
