<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\User::class => \App\Policies\AuthorPolicy::class,
        \App\Models\Book::class => \App\Policies\BookPolicy::class,
        \App\Models\Genre::class => \App\Policies\GenrePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
