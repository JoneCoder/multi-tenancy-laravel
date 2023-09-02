<?php

namespace App\Http\Controllers;

use App\Events\Tenant\TenantCreated;
use App\Http\Requests\TenantRequest;
use App\Jobs\AllTenantMigration;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception, DB;

class MasterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TenantRequest $request
     * @return JsonResponse
     */
    public function createTenant(TenantRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $tenant = Tenant::create($request->all());

            event(new TenantCreated($tenant));

            DB::commit();
            return response()->json(['message' => 'Create Successfully!'], 200);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json($ex->errorInfo, 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TenantRequest $request
     * @return JsonResponse
     */
    public function allTenantMigrationQueue(Request $request): JsonResponse
    {
        try {
            AllTenantMigration::dispatch('fresh');
            return response()->json(['message' => 'Queue Run Successfully!'], 200);
        } catch (Exception $ex) {
            return response()->json($ex->errorInfo, 422);
        }
    }
}
