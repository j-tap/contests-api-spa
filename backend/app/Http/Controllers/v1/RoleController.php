<?php

namespace App\Http\Controllers\v1;

use App\Services\Role\RoleService;
use Illuminate\Http\JsonResponse;
use App\Services\Helper\Api;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;

class RoleController extends Controller
{
    private $roleService;

    /**
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [];
        $roles = $this->roleService->get();
        if ($roles->isNotEmpty()) {
            $result = new RoleCollection($roles);
        }
        return Api::onSuccess(data: $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->get($id);
        $result = new RoleResource($role);
        return Api::onSuccess(data: $result);
    }
}
