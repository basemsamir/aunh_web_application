<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View\Composer;

class MedicalCategoryComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('home.*', 'App\Http\ViewComposers\HomeComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
      
    }
}
