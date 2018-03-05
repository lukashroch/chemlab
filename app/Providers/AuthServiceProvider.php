<?php

namespace ChemLab\Providers;

use ChemLab\ChemicalItem;
use ChemLab\Policies\ChemicalItemPolicy;
use ChemLab\Store;
use ChemLab\Policies\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        //
    }
}
