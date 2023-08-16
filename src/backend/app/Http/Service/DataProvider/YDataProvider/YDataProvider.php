<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider\YDataProvider;

use App\Enum\TransactionStatus;
use App\Http\Service\DataProvider\BaseProvider;
use App\Http\Service\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class YDataProvider extends BaseProvider
{
    public function getData(): Collection
    {
        $fileContent = File::get(storage_path(path: 'DataProviderY.json'));

        $data = json_decode(json: $fileContent, associative: true);

        $data = $this->hydrateTransactionObject(transactions: $data);

        return collect(value: $data);
    }

    /**
     * @param array $transactions
     * @return Transaction[]
     */
    private function hydrateTransactionObject(array $transactions): array
    {
        return array_map(
            callback: fn($transaction) => new Transaction(
                id: $transaction['id'],
                email: $transaction['email'],
                amount: $transaction['balance'],
                currency: $transaction['currency'],
                status: $this->getStatus(statusCode: $transaction['status']),
                date: Carbon::createFromFormat(format: 'd/m/Y', time: $transaction['created_at']),
                provider: 'DataProviderY'
            ),
            array: $transactions
        );
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
