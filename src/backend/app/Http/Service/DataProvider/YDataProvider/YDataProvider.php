<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider\YDataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use App\Http\Service\DataProvider\BaseDataProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class YDataProvider extends BaseDataProvider
{
    /**
     * @param string $filePath
     * @return Collection
     */
    public function getData(string $filePath): Collection
    {
        $data = parent::getData($filePath);

        return $this->getTransformedCollection(transactions: $data);
    }

    /**
     * @param Collection $transactions
     * @return Collection of Transaction objects
     */
    protected function getTransformedCollection(Collection $transactions): Collection
    {
        return $transactions->transform(
            callback: function ($transaction): ?Transaction {
                if (!$this->arrayHasKeys(keys: ['id', 'email', 'balance', 'currency', 'status', 'created_at'], array: $transaction)) {
                    return null;
                }

                return new Transaction(
                    id: $transaction['id'],
                    email: $transaction['email'],
                    amount: $transaction['balance'],
                    currency: $transaction['currency'],
                    status: $this->getStatus(statusCode: $transaction['status']),
                    date: Carbon::createFromFormat(format: 'd/m/Y', time: $transaction['created_at']),
                    provider: 'DataProviderY'
                );
            }
        )->filter(fn ($transaction) => !is_null(value: $transaction));
    }

    /**
     * @param int $statusCode
     * @return TransactionStatus
     */
    private function getStatus(int $statusCode): TransactionStatus
    {
        return match ($statusCode) {
            100 => TransactionStatus::Authorized,
            200 => TransactionStatus::Decline,
            300 => TransactionStatus::Refunded
        };
    }
}
