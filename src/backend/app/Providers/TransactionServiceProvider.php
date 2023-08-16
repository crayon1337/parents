<?php

namespace App\Providers;

use App\Http\Service\TransactionInterface;
use App\Http\Service\TransactionService;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(abstract: TransactionInterface::class, concrete: TransactionService::class);
    }
}
