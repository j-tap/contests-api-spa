<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use App\Services\Helper\Api;
use Throwable;
use App\Services\Helper\Convertation;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Необходима авторизация
        $this->renderable(function (AuthenticationException $e, $request) {
            $code = 401;
            $message = __('errors.code_401');
            return $this->print(code: $code, message: $message);
        });

        // Действие не разрешено
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            $code = 403;
            $message = __('message.action_is_unauthorized');
            return $this->print(code: $code, message: $message);
        });

        // Не найден путь
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $code = 404;
            $message = __('errors.code_404');
            return $this->print(code: $code, message: $message);
        });

        // Не найдена модель
        $this->renderable(function (ModelNotFoundException $e, $request) {
            $code = 404;
            $message = __('errors.code_404');
            $info['model'] = $e->getModel();
            return $this->print(code: $code, message: $message, info: $info);
        });

        // Не поддерживаемый метод
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            $info['allow_method'] = Convertation::objectToString($e->getHeaders());
            $code = 405;
            $message = __('message.method_is_not_supported_for_this_route');
            return $this->print(code: $code, message: $message, info: $info);
        });

        // Ошибка валидации
        $this->renderable(function (ValidationException $e, $request) {
            $code = 422;
            $message = __('message.data_filled_out_incorrectly');
            $errors = $e->errors();
            return $this->print(code: $code, message: $message, errors: $errors);
        });

        // Другие ошибки
        $this->renderable(function (Throwable $e) {
            $code = 500;

            if (method_exists($e, 'getStatusCode')) {
                $code = $e->getStatusCode();
            }
            if (method_exists($e, 'getError')) {
                $info['error'] = $e->getError();
            }
            if (method_exists($e, 'getFile')) {
                $info['file'] = $e->getFile();
            }
            if (method_exists($e, 'getLine')) {
                $info['line'] = $e->getLine();
            }

            $info['instance'] = get_class($e);
            $message = $e->getMessage();

            return $this->print(code: $code, message: $message, info: $info);
        });
    }

    /**
     * Отображение ошибок
     *
     * @param  int $code
     * @param  string $message
     * @param  array $info
     * @return JsonResponse
     */
    private function print($code = null, $message = '', $info = [], $errors = null): JsonResponse
    {
        return Api::onError(code: $code, message: $message, info: $info, errors: $errors);
    }

}
