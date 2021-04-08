<?php

namespace App\Providers;

use App\Models\Wallet;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when('App\Repositories\WalletRepository')
            ->needs('App\Models\Wallet')
            ->give(function () {
                return new Wallet();
        });

        $this->app->when('App\Services\WalletService')
            ->needs('App\Interfaces\IWalletRepository')
            ->give('App\Repositories\WalletRepository');

        $this->app->when('App\Http\Controllers\Api\WalletController')
            ->needs('App\Interfaces\IWalletService')
            ->give('App\Services\WalletService');
    }
}
