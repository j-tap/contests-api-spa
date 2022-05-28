<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\CareerController;
use App\Http\Controllers\v1\CompanyController;
use App\Http\Controllers\v1\ContestController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\RoleController;
use App\Http\Controllers\v1\LandingTemplateController;
use App\Http\Controllers\v1\SettingController;
use App\Http\Controllers\v1\StatusController;
use App\Http\Controllers\v1\SettingTypeController;
use App\Http\Controllers\v1\SystemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function ()
{
    /* Открытый доступ */
    // Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('/login', [AuthController::class, 'login']);

    /* Только авторизованным (менеджеры) */
    Route::group(['middleware' => ['auth:sanctum']], function ()
    {
        Route::get('/logout', [AuthController::class, 'logout']);
        // Route::get('/profile', [AuthController::class, 'profile']);

        Route::apiResources([
            'careers' => CareerController::class,
        ]);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show'])
            ->whereNumber('id');
        Route::get('/users/{id}/winner', [UserController::class, 'winner'])
            ->whereNumber('id');

        Route::patch('/users/{id}/participant', [UserController::class, 'participantUpdate'])
            ->whereNumber('id');

        Route::get('/companies', [CompanyController::class, 'index']);
        Route::get('/companies/{id}', [CompanyController::class, 'show'])
            ->whereNumber('id');

        Route::get('/contests', [ContestController::class, 'index']);
        Route::post('/contests', [ContestController::class, 'store']);
        Route::post('/contests/{id}/qr', [ContestController::class, 'qr'])
            ->whereNumber('id');
        Route::get('/contests/{id}/participants', [ContestController::class, 'participants'])
            ->whereNumber('id')
            ->middleware('tg.logged');
        Route::get('/contests/{id}', [ContestController::class, 'show'])
            ->whereNumber('id')
            ->middleware('tg.logged');
        Route::patch('/contests/{id}', [ContestController::class, 'update'])
            ->whereNumber('id');

        Route::get('/statuses', [StatusController::class, 'index']);

        Route::get('/templates', [LandingTemplateController::class, 'index']);

        Route::get('/settings', [SettingController::class, 'index']);
        Route::patch('/settings/updates', [SettingController::class, 'updateMultiple']);

        Route::get('/settings-types', [SettingTypeController::class, 'index']);

        /* Только администраторам */
        Route::group(['middleware' => ['role:admin']], function ()
        {
            Route::delete('/contests/{id}', [ContestController::class, 'destroy'])
                ->whereNumber('id');

            Route::post('/users', [UserController::class, 'store']);
            Route::patch('/users/{id}', [UserController::class, 'update'])
                ->whereNumber('id');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])
                ->whereNumber('id');

            Route::post('/companies', [CompanyController::class, 'store']);
            Route::patch('/companies/{id}', [CompanyController::class, 'update'])
                ->whereNumber('id');
            Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])
                ->whereNumber('id');

            Route::get('/roles', [RoleController::class, 'index']);
            Route::get('/roles/{id}', [RoleController::class, 'show'])
                ->whereNumber('id');

            Route::post('/templates', [LandingTemplateController::class, 'store']);
            Route::patch('/templates/{id}', [LandingTemplateController::class, 'update'])
                ->whereNumber('id');
            Route::delete('/templates/{id}', [LandingTemplateController::class, 'destroy'])
                ->whereNumber('id');

            Route::post('/settings', [SettingController::class, 'store']);
            Route::patch('/settings/{id}', [SettingController::class, 'update'])
                ->whereNumber('id');
            // Route::delete('/settings/{id}', [SettingController::class, 'destroy'])->whereNumber('id');

            Route::get('/system/log', [SystemController::class, 'log']);

            Route::get('/system/tg/status', [SystemController::class, 'tgStatus']);
            Route::post('/system/tg/auth', [SystemController::class, 'tgAuth']);
            Route::get('/system/tg/logout', [SystemController::class, 'tgLogout']);
        });
    });

});
