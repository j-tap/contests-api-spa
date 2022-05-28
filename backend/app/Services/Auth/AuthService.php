<?php

namespace App\Services\Auth;

use App\Services\BaseControllerService;
// use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\LoginResource;
use App\Models\User;
use App\Services\User\UserService;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\Helper\RoleCheck;

class AuthService extends BaseControllerService
{
    private static $tokenType = 'userAuthorizationToken';
    private $userService;

    /**
     * @param  UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Регистрация нового пользователя
     *
     * @param  RegistrationRequest $request
     * @return LoginResource
     */
    public function registration(RegistrationRequest $request): LoginResource
    {
        $user = $this->userService->create($request);

        $result['user'] = $user;
        $result['token'] = $user->createToken($this::$tokenType)->plainTextToken;

        return new LoginResource($result);
    }

    /**
     * Авторизация пользователя
     *
     * @param LoginRequest $request
     * @return LoginResource
     */
    public function login(LoginRequest $request): LoginResource | false
    {
        $roleUser = RoleCheck::ROLES['user'];
        $user = User::where('email', $request->email)
            ->where('role_id', '<', $roleUser)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return false;
        }

        $result['token'] = $user->createToken($this::$tokenType)->plainTextToken;
        $result['user'] = $user;

        return new LoginResource($result);
    }

    /**
     * Профиль текущего пользователя
     *
     * @return User
     */
    public function getProfile(): User
    {
        $user = auth()->user();
        return $user;
    }

    /**
     * Удаление текущего токена пользователя
     *
     * @param  Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }

}
