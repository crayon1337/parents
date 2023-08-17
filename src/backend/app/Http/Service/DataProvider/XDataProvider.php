<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use App\DTO\Transaction;
use App\Enum\TransactionStatus;
use Illuminate\Support\Carbon;

final class XDataProvider
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
                id: $row['parentIdentification'],
                email: $row['parentEmail'],
                amount: $row['parentAmount'],
                currency: $row['Currency'],
                status: $this->getStatus(statusCode: $row['statusCode']),
                date: Carbon::createFromFormat(format: 'Y-m-d', time: $row['registrationDate']),
                provider: 'DataProviderX'
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
        return $this->arrayHasKeys(
            keys: ['parentIdentification', 'parentEmail', 'parentAmount', 'Currency', 'statusCode', 'registrationDate'],
            array: $row
        );
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
