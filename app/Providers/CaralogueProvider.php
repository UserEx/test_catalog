<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ImportCatalogueService;
use Illuminate\Support\Facades\Route;
use App\Service\CatalogueUpdateEventSubscriber;

class CaralogueProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {       
        Route::get('/', 'App\Http\Controllers\CatalogueController@index');
        Route::get('/{slug}', 'App\Http\Controllers\CatalogueController@showCategoryBySlug')
            ->where('slug', '([A-Za-z0-9\-\/]+)')
            ->name('showCategoryBySlug');
        
        
        $this->app->make('em');
        $this->app->get('em')->getEventManager()->addEventSubscriber($this->app->make('App\Service\CatalogueUpdateEventSubscriber'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Service\ImportCatalogueService');
        $this->app->bind('App\Service\CatalogueUpdateEventSubscriber', function ($app) {
            return new CatalogueUpdateEventSubscriber($app->make('em'));
        });
    }
}
