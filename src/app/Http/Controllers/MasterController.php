<?php

namespace App\Http\Controllers;

use App\Events\Tenant\TenantCreated;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;

class MasterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TenantRequest $request
     * @return JsonResponse
     */
    public function createTenant(TenantRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $tenant = Tenant::create($request->all());

            event(new TenantCreated($tenant));

            return response()->json(['message' => 'Create Successfully!'], 200);
        } catch (Exception $ex) {
            return response()->json($ex->errorInfo, 422);
        }
    }
}
