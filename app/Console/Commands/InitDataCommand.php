<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class InitDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate initial data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Run migration database...');
        Artisan::call('migrate');

        $this->line('Generate data users...');
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);

        $this->line('Generate data categories...');
        Artisan::call('db:seed', ['--class' => 'CategorySeeder']);
       
        $this->line('Generate data posters...');
        Artisan::call('db:seed', ['--class' => 'PosterSeeder']);

        $this->line('Initilizing passport...');
        Artisan::call('passport:install');
    }
}
