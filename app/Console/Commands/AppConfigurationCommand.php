<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppConfigurationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:configuration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to configuration the app';

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
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->info('---');        
        $this->call('db:seed');
        $this->info('---');
        $this->warn('Executing tests');
        $this->call('test');
        $this->info('Executed');
        $this->info('---');
        $this->info("Finish. Now your application is up and listen the queue for async jobs");
        $this->call('queue:work', ['--queue' => 'high,default']);
        
        

        return 0;
    }
}
