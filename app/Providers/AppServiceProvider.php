<?php

namespace App\Providers;

use App\Facades\Util;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Jackiedo\DotenvEditor\DotenvEditorServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //

        app()->singleton("util", function ($app) {
            return new \App\Helper\Util();
        });

        view()->share('util', app(\App\Facades\Util::class));


        app()->singleton("common", function ($app) {
            return new \App\Helper\Common();
        });

        view()->share('common', app(\App\Facades\Common::class));

        app()->singleton("cform", function ($app) {
            return new \App\Helper\CForm();
        });

        if (! config('app.installed')) {
            $this->app->register(DotenvEditorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
            URL::forceScheme('http');
    }
}
