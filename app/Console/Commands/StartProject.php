<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('passport:install');
        $this->call('passport:client', ['--personal' => true, '--name' => 'Personal Access Token']);
        $this->call('key:generate');
    }
}
