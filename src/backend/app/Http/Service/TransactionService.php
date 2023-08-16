<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Service\DataProvider\BaseProvider;
use App\Http\Service\DataProvider\XDataProvider\XDataProvider;
use App\Http\Service\DataProvider\YDataProvider\YDataProvider;
use Illuminate\Support\Collection;

final class TransactionService implements TransactionInterface
{
    /**
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        $transactions = collect();

        $providerXData = $this->resolveProviderData(new XDataProvider());
        $providerYData = $this->resolveProviderData(new YDataProvider());

        $transactions->add($providerXData);
        $transactions->add($providerYData);

        return $transactions->flatten();
    }

    /**
     * @param BaseProvider $provider
     * @return Collection
     */
    private function resolveProviderData(BaseProvider $provider): Collection
    {
        return $provider->getData();
    }
}
