<?php

namespace App\Services\Role;

use App\Services\BaseControllerService;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RoleService extends BaseControllerService
{
    /**
     * Получение ролей
     *
     * @return Collection | Role
     */
    public function get(int $id = null): Collection | Role
    {
        /* Отдавать роли выше или равно текущей */
        $roleCurrent = Auth::user()->role->id;

        if (is_int($id)) {
            $result = Role::where('id', '>=', $roleCurrent)->findOrFail($id);
        }
        else {
            $result = Role::where('id', '>=', $roleCurrent)->get();
        }
        return $result;
    }
}
