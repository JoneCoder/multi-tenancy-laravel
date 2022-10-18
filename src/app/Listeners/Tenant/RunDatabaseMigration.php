<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseMigration;
use Illuminate\Support\Facades\Artisan;

class RunDatabaseMigration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DatabaseMigration $event
     * @return bool
     */
    public function handle(DatabaseMigration $event): bool
    {
        $tenant = $event->tenant();
        $migration = Artisan::call('tenants:migrate', ['id' => $tenant->id]);
        return $migration === 0;
    }
}
