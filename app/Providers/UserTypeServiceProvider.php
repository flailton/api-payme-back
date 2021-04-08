<?php

namespace App\Providers;

use App\Models\UserType;
use Illuminate\Support\ServiceProvider;

class UserTypeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\UserTypeRepository')
            ->needs('App\Models\UserType')
            ->give(function () {
                return new UserType();
        });

        $this->app->when('App\Services\UserTypeService')
                ->needs('App\Interfaces\IUserTypeRepository')
            ->give('App\Repositories\UserTypeRepository');

        $this->app->when('App\Http\Controllers\Api\UserTypeController')
            ->needs('App\Interfaces\IUserTypeService')
            ->give('App\Services\UserTypeService');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
