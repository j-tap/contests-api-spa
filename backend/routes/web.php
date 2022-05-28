<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\ContestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Открытый доступ */
Route::group(['middleware' => ['cors.allow']], function ()
{
    Route::get('/contest/{hash}', [ContestController::class, 'infoByHash'])
        ->where('hash', '[a-zA-Z0-9]{100,250}=*$');
    Route::post('/contest/registration', [ContestController::class, 'registration']);
});
