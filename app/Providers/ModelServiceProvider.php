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
        Route::bind('event_type_onlytrashed', function ($id) {
            return \App\Model\Eloquent\EventType::onlyTrashed()->findOrFail($id);
        });
        Route::bind('shool_system_onlytrashed', function ($id) {
            return \App\Model\Eloquent\EventType::onlyTrashed()->findOrFail($id);
        });
        Route::bind('identity_onlytrashed', function ($id) {
            return \App\Model\Eloquent\Identity::onlyTrashed()->findOrFail($id);
        });
        Route::bind('interest_onlytrashed', function ($id) {
            return \App\Model\Eloquent\Interest::onlyTrashed()->findOrFail($id);
        });
    }

    public function bootModelObserver()
    {
        \App\Model\Eloquent\File::observe(new \App\Model\Observer\File());
    }
}
