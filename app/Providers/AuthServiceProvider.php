<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Advertisement;
use App\Policies\Advertisement\AdvertisementPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Advertisement::class => AdvertisementPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
