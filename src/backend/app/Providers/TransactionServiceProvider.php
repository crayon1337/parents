<?php

namespace App\Providers;

use App\Http\Service\TransactionContract;
use App\Http\Service\TransactionService;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(abstract: TransactionContract::class, concrete: TransactionService::class);
    }
}
