<?php

namespace App\Providers;

use App\Jobs\ProcessImportations;
use App\Services\ImportationsProcessor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->bindMethod([ProcessImportations::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(ImportationsProcessor::class));
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
