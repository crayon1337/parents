<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider\XDataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use App\Http\Service\DataProvider\BaseDataProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class XDataProvider extends BaseDataProvider
{
    /**
     * @param string $filePath
     * @return Collection
     */
    public function getData(string $filePath): Collection
    {
        $data = parent::getData($filePath);

        return $this->getTransformedCollection(data: $data);
    }

    /**
     * @param Collection $data
     * @return Collection of Transaction objects
     */
    protected function getTransformedCollection(Collection $data): Collection
    {
        return $data->transform(
            callback: function ($transaction): ?Transaction {
                if (!$this->arrayHasKeys(
                    keys: ['parentIdentification', 'parentEmail', 'parentAmount', 'Currency', 'statusCode', 'registrationDate'],
                    array: $transaction
                )) {
                    return null;
                }

                return new Transaction(
                    id: $transaction['parentIdentification'],
                    email: $transaction['parentEmail'],
                    amount: $transaction['parentAmount'],
                    currency: $transaction['Currency'],
                    status: $this->getStatus(statusCode: $transaction['statusCode']),
                    date: Carbon::createFromFormat(format: 'Y-m-d', time: $transaction['registrationDate']),
                    provider: 'DataProviderX'
                );
            }
        )->filter(fn ($transaction) => !is_null(value: $transaction));
    }

    /**
     * @param int $statusCode
     * @return TransactionStatus|null
     */
    private function getStatus(int $statusCode): ?TransactionStatus
    {
        return match ($statusCode) {
            1 => TransactionStatus::Authorized,
            2 => TransactionStatus::Decline,
            3 => TransactionStatus::Refunded,
            default => null
        };
    }
}
