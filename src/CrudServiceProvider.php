<?php namespace Vlasenkov\Crud;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CrudServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerViews();
        $this->registerPublic();
    }

    /**
     * Register and publish default views
     *
     * @return void();
     */    
    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'crud');        
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/crud'),
        ], 'public');        
    }
    
    /**
     * Register and publish default css
     *
     * @return void();
     */     
    private function registerPublic()
    {        
        $this->publishes([
            __DIR__ . '/public' => public_path('crud'),
        ], 'public');
    }
}
