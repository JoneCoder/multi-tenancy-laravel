<?php

namespace App\Tenant;

use App\Models\Tenant;
use App\Models\Tenant\Organize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TenantManager
{
    public function setConnection(Tenant $tenant): void
    {
        Config::set("database.connections.mysql2", ["database" => $tenant->db_name]);
    }

    public function setConnectionOrganize(Organize $organize): void
    {
        Config::set("database.connections.mysql3", ["database" => $organize->db_name]);
    }

    public function isMasterDomain(Request $request): bool
    {
        if($request->getHost() == config('tenant.master_domain'))return true;
        return false;
    }

}
