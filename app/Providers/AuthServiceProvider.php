<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ComunidadePost;
use App\Policies\ComunidadePostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ComunidadePost::class => ComunidadePostPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
