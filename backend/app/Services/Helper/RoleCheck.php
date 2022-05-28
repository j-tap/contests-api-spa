<?php

namespace App\Services\Helper;

use App\Models\User;

class RoleCheck
{
    /* Константы ролей */
    const ROLES = [
        'admin' => 1,
        'manager' => 10,
        'user' => 100,
    ];

    /**
     * Проверка роли Admin
     *
     * @param  User | null $user
     * @return bool
     */
    public static function isAdmin(User | null $user): bool
    {
        if ($user && !empty($user)) {
            return $user->role_id === self::ROLES['admin'];
        }
        return false;
    }

    /**
     * Проверка роли Manager
     *
     * @param  User | null $user
     * @return bool
     */
    public static function isManager(User | null $user): bool
    {
        if ($user && !empty($user)) {
            return $user->role_id === self::ROLES['manager'];
        }
        return false;
    }

    /**
     * Проверка роли User
     *
     * @param  User | null $user
     * @return bool
     */
    public static function isUser(User | null $user): bool
    {
        if ($user && !empty($user)) {
            return $user->role_id === self::ROLES['user'];
        }
        return false;
    }

}
