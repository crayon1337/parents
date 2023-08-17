<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use Illuminate\Support\Carbon;

final class YDataProvider
{
    use CanReadJsonFile;

    /**
     * @return array of Transaction objects
     */
    public function get(): array
    {
        $data = [];

        foreach ($this->data as $row) {
            if (!$this->validScheme($row)) {
                continue;
            }

            $data[] = new Transaction(
                id: $row['id'],
                email: $row['email'],
                amount: $row['balance'],
                currency: $row['currency'],
                status: $this->getStatus(statusCode: $row['status']),
                date: Carbon::createFromFormat(format: 'd/m/Y', time: $row['created_at']),
                provider: 'DataProviderY'
            );
        }

        return $data;
    }

    /**
     * @param array $row
     * @return bool
     */
    private function validScheme(array $row): bool
    {
        return $this->arrayHasKeys(keys: ['id', 'email', 'balance', 'currency', 'status', 'created_at'], array: $row);
    }

    /**
     * @param int $statusCode
     * @return TransactionStatus|null
     */
    private function getStatus(int $statusCode): ?TransactionStatus
    {
        return match ($statusCode) {
            100 => TransactionStatus::Authorized,
            200 => TransactionStatus::Decline,
            300 => TransactionStatus::Refunded,
            default => null
        };
    }
}
