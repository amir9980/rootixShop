<?php

namespace App\Providers;

use App\Models\factorMaster;
use App\Models\user;
use App\Models\WalletPayment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;


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
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        Relation::morphMap([
            'user' => user::class,
            'factor' => factorMaster::class,
            'wallet' => WalletPayment::class,
        ]);

    }
}
