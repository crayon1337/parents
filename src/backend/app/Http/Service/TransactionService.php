<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\DTO\Transaction;
use App\Http\Requests\GetUsersRequest;
use App\Http\Service\DataProvider\XDataProvider\XDataProvider;
use App\Http\Service\DataProvider\YDataProvider\YDataProvider;
use Illuminate\Support\Collection;

final class TransactionService implements TransactionContract
{
    /**
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        $transactions = collect([
            (new XDataProvider())->getData(filePath: 'DataProviderX.json'),
            (new YDataProvider())->getData(filePath: 'DataProviderY.json')
        ]);

        return $transactions->flatten();
    }

    /**
     * Filters the given transactions using inputs from the given request.
     *
     * @param GetUsersRequest $request
     * @param Collection $transactions
     * @return Collection
     */
    public function filterTransactions(GetUsersRequest $request, Collection $transactions): Collection
    {
        // Define each supported filter and the condition to be applied for each filter.
        $filters = [
            'provider' => fn ($value, Transaction $transaction): bool => $transaction->getProvider() === $value,
            'status' => fn ($value, Transaction $transaction): bool => $transaction->getStatus()->value === $value,
            'balanceMin' => fn ($value, Transaction $transaction): bool => $transaction->getAmount() >= $value,
            'balanceMax' => fn ($value, Transaction $transaction): bool => $transaction->getAmount() <= $value,
            'currency' => fn ($value, Transaction $transaction): bool => $transaction->getCurrency() === $value,
        ];

        // Iterate through the filters and filter the transactions collection using the callback defined above.
        foreach ($filters as $key => $filter) {
            $value = $request->input($key);

            if ($value !== null) {
                $transactions = $transactions->filter(
                    callback: fn (Transaction $transaction): bool => $filter($value, $transaction)
                );
            }
        }

        return $transactions;
    }
}
