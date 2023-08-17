<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class XDataProvider
{
    use CanReadFile;

    /**
     * @return Collection of Transaction objects
     */
    public function get(): Collection
    {
        return $this->data->transform(
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
