<?php

namespace App\Console\Commands\Tenant;

use App\Models\Tenant;
use App\Tenant\TenantManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use DB;

class RunMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {id} {--fresh}';


    public TenantManager $tenant;

    /**
     * Create a new command instance.
     *
     * @param TenantManager $tenant
     */
    public function __construct(TenantManager $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations on tenants databases';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if($id = $this->argument('id')){
            $tenant = Tenant::find($id);
            if($tenant) $this->execCommand($tenant);
            return 1;
        }

        $tenants = Tenant::all();
        foreach ($tenants as $tenant){
            $this->execCommand($tenant);
        }
        return 1;
    }

    /**
     * Execute the console command.
     *
     * @param Tenant $tenant
     */
    public function execCommand(Tenant $tenant)
    {
        $command = $this->option('fresh')? 'migrate:fresh' : 'migrate';

        $this->tenant->setConnection($tenant);

        $this->info("Connecting to {$tenant->name}");

        Artisan::call($command, [
            '--database' => 'mysql2',
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);

        Artisan::call('db:seed',[
            '--class' => 'TenantSeeder'
        ]);

        $this->info("End Connecting to {$tenant->name}");
        $this->info("_________________________________");
    }
}
