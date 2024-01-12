<?php

namespace App\Providers;

use App\Models\Auction;
use App\Repositories\Interfaces\AuctionRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\SearchRepositoryInterface;
use App\Repositories\SearchRepository;
use App\Repositories\AuctionRepository;

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
        $this->app->bind(AuctionRepositoryInterface::class, AuctionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
