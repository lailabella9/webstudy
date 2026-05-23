<?php

namespace App\Providers;

use App\Models\Materi;
use App\Policies\MateriPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Materi::class => MateriPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
