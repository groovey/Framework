<?php

namespace Groovey\Framework\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class About extends Command
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
            ->setName('about')
            ->setDescription('Shows the database connection information.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app         = $this->app;
        $environment = strtolower(ENVIRONMENT);
        $host        = $app->config('database.mysql.host');
        $database    = $app->config('database.mysql.database');
        $version     = '0.0.0'; // TODO : Version Manager

        $about = <<<ABOUT
 <comment>
    ______
   / ____/________  ____ _   _____  __  __
  / / __/ ___/ __ \/ __ \ | / / _ \/ / / /
 / /_/ / /  / /_/ / /_/ / |/ /  __/ /_/ /
 \____/_/   \____/\____/|___/\___/\__, /
                                 /____/
 </comment>
 Project Name : Groovey
 Author : Harold Kim Cantil <pokoot@gmail.com>

 Crafted with love.

 Version: $version
 Environment : $environment
 Host: $host
 Database : $database

ABOUT;

        $output->writeln($about);
    }
}
