<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\SearchRepositoryInterface;
use App\Repositories\SearchRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerSearchRepository();
    }

    public function registerSearchRepository(): void
    {
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
