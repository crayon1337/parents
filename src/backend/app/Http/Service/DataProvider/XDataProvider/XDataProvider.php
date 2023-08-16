<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider\XDataProvider;

use App\Enum\TransactionStatus;
use App\Http\Service\DataProvider\BaseProvider;
use App\Http\Service\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class XDataProvider extends BaseProvider
{
    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        $fileContent = File::get(storage_path(path: 'DataProviderX.json'));

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
            callback: fn ($transaction) => new Transaction(
                id: $transaction['parentIdentification'],
                email: $transaction['parentEmail'],
                amount: $transaction['parentAmount'],
                currency: $transaction['Currency'],
                status: $this->getStatus(statusCode: $transaction['statusCode']),
                date: Carbon::createFromFormat(format: 'Y-m-d', time: $transaction['registrationDate']),
                provider: 'DataProviderX'
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
            1 => TransactionStatus::Authorized,
            2 => TransactionStatus::Decline,
            3 => TransactionStatus::Refunded
        };
    }
}
