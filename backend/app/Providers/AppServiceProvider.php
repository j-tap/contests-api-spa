<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Tg\TgApi;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* Чтобы был один экземпляр класса TgApi */
        $this->app->singleton(TgApi::class, function($app)
        {
			return new TgApi();
		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
