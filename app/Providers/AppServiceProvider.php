<?php

namespace ChemLab\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Schema::defaultStringLength(191);
        Env::disablePutenv();
    }
}
