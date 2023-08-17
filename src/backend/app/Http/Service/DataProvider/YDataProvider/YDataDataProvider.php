<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider\YDataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use App\Http\Service\DataProvider\BaseDataProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class YDataDataProvider extends BaseDataProvider
{
    public function getData(): Collection
    {
        $fileContent = File::get(storage_path(path: 'DataProviderY.json'));

        $data = json_decode(json: $fileContent, associative: true);

        $data = collect(value: $data);

        return $this->getTransformedCollection(transactions: $data);
    }

    /**
     * @param Collection $transactions
     * @return Collection of Transaction objects
     */
    private function getTransformedCollection(Collection $transactions): Collection
    {
        return $transactions->transform(
            callback: fn ($transaction) => new Transaction(
                id: $transaction['id'],
                email: $transaction['email'],
                amount: $transaction['balance'],
                currency: $transaction['currency'],
                status: $this->getStatus(statusCode: $transaction['status']),
                date: Carbon::createFromFormat(format: 'd/m/Y', time: $transaction['created_at']),
                provider: 'DataProviderY'
            )
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
