<?php

namespace ChemLab\Providers;

use ChemLab\Models\ChemicalItem;
use ChemLab\Models\Store;
use ChemLab\Policies\ChemicalItemPolicy;
use ChemLab\Policies\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ChemicalItem::class => ChemicalItemPolicy::class,
        Store::class => StorePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
