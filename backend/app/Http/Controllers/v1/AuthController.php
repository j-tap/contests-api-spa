<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\AuthService;
use App\Services\Helper\Api;
use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Регистрация нового пользователя
     *
     * @param  RegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $data = $this->authService->registration($request);
        $result['user'] = new ProfileResource($data['user']);
        $result['token'] = $data['token'];
        return Api::onSuccess(data: $result);
    }

    /**
     * Авторизация пользователя
     *
     * @param  LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request);

        if ($data) {
            $result['user'] = new ProfileResource($data['user']);
            $result['token'] = $data['token'];
            return Api::onSuccess(data: $result);
        }

        return Api::onError(code: 422, message: __('message.login_or_password_is_incorrect'));
    }

    /**
     * Профиль текущего пользователя
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $this->authService->getProfile();
        $result = new ProfileResource($user);
        return Api::onSuccess(data: $result);
    }

    /**
     * Выход
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);
        return Api::onSuccess(message: __('message.success'));
    }

}
