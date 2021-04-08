<?php

namespace App\Providers;

use App\Models\Transference;
use Illuminate\Support\ServiceProvider;

class TransferenceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\TransferenceRepository')
            ->needs('App\Models\Transference')
            ->give(function () {
                return new Transference();
        });

        $this->app->when('App\Services\TransferenceService')
            ->needs('App\Interfaces\ITransferenceRepository')
            ->give('App\Repositories\TransferenceRepository');
            
        $this->app->when('App\Services\TransferenceService')
            ->needs('App\Interfaces\IUserService')
            ->give('App\Services\UserService');

        $this->app->when('App\Http\Controllers\Api\TransferenceController')
            ->needs('App\Interfaces\ITransferenceService')
            ->give('App\Services\TransferenceService');
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
