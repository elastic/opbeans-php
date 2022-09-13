<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $packageJson = json_decode(
            file_get_contents(base_path('package.json')),
            true
        );

        view()->composer('*', function($view) use ($packageJson) {
            $isElasticApmEnabled = function_exists('elastic_apm_is_enabled') && \elastic_apm_is_enabled();
            $view->with('isElasticApmEnabled', $isElasticApmEnabled);
            if ($isElasticApmEnabled) {
                $view->with('elasticApmJsServiceName', isset($packageJson['name']) ? $packageJson['name'] : env('ELASTIC_APM_JS_SERVICE_NAME'));
                $view->with('elasticApmJsServiceVersion', isset($packageJson['version']) ? $packageJson['version'] : env('ELASTIC_APM_JS_SERVICE_VERSION'));
                $view->with('elasticApmJsServerUrl', env('ELASTIC_APM_JS_SERVER_URL'));
                $view->with('elasticApmCurrentTransaction', \Elastic\Apm\ElasticApm::getCurrentTransaction());
            }
        });
    }
}
