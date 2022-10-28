<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Tenant\TenantManager;
use Illuminate\Support\Facades\Artisan;

class TenantMigration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Tenant $tenant;
    protected $option;
    protected $tries         = 5;
    protected $maxExceptions = 3;
    protected $timeout       = 120;

    public TenantManager $tenantManager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tenant, $option = null)
    {
        $this->tenant = $tenant;
        $this->tenantManager = new TenantManager();
        $this->option = $option;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if($this->tenant) $this->execCommand($this->tenant);
    }

    /**
     * Execute the console command.
     *
     * @param Tenant $tenant
     */
    public function execCommand(Tenant $tenant)
    {
        $command = $this->option == 'fresh'? 'migrate:fresh' : 'migrate';
        $this->tenantManager->setConnection($tenant);
        Artisan::call($command, [
            '--database' => 'mysql2',
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);
    }
}
