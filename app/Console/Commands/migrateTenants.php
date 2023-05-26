<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class migrateTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:tenants {db_name} {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates migration for the specified database';

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
        $database = $this->argument('db_name');
        $fresh = $this->option('fresh');

        Config::set('database.connections.tenant.database', $database);

        if($fresh) {
            Artisan::call('migrate:fresh', [
                '--path' => 'database/migrations/tenants',
                '--database' => 'tenant'
            ]);
        } else {
            Artisan::call('migrate', [
                '--path' => 'database/migrations/tenants',
                '--database' => 'tenant'
            ]);
        }


    }
}
