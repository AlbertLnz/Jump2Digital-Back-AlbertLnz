<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(UrlGenerator $url): void
    {
        if(env('APP_ENV') == 'production'){
            $url->forceScheme('https');
        }
    }
}
