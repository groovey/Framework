<?php

namespace Groovey\Framework\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Groovey\Support\Output;

class DB extends Command
{
    public $app;

    public function __construct($app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('db')
            ->setDescription('Shows the database connection string.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app         = $this->app;
        $output      = Output::style($output);
        $environment = strtolower(ENVIRONMENT);
        $host        = $app['config']->get('database.mysql.host');
        $database    = $app['config']->get('database.mysql.database');

        $output->writeln("<highlight>Database connection info:</highlight>");
        $output->writeln("<info>Environment : $environment</info>");
        $output->writeln("<info>Host : $host</info>");
        $output->writeln("<info>Database : $database</info>");

    }
}
