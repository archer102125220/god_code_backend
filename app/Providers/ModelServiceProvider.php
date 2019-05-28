<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModelServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
        $this->bootRouteModel();
        $this->bootModelObserver();
    }

    public function bootRouteModel()
    {
        Route::bind('user', function ($id) {
            return \App\Model\Eloquent\User::with(['roles'])->findOrFail($id);
        });
        Route::bind('user_onlytrashed', function ($id) {
            return \App\Model\Eloquent\User::with(['roles'])->onlyTrashed()->findOrFail($id);
        });
    }

    public function bootModelObserver()
    {
        \App\Model\Eloquent\File::observe(new \App\Model\Observer\File());
    }
}
