<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class AllTenantMigration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $option;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($option)
    {
        $this->option = $option;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $tenants = Tenant::select('id', 'name', 'email', 'subdomain', 'db_name', 'admin_id')->get();
        foreach ($tenants as $tenant){
            TenantMigration::dispatch($tenant, $this->option);
        }
    }
}
