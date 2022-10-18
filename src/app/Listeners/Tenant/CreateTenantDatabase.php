<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseMigration;
use App\Events\Tenant\TenantCreated;
use App\Tenant\DatabaseManager;

class CreateTenantDatabase
{
    public DatabaseManager $database;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->database = new DatabaseManager();
    }

    /**
     * Handle the event.
     *
     * @param TenantCreated $event
     * @return void
     * @throws \Exception
     */
    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant();

        if(!$this->database->createDatabase($tenant)){
            throw new \Exception(trans('cruds.tenant.database.create_error'));
        }

        event(new DatabaseMigration($tenant));
    }
}
