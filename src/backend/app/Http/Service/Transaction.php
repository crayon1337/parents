<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Enum\TransactionStatus;
use Illuminate\Support\Carbon;

final class Transaction
{
    public function __construct(
        protected string $id,
        protected string $email,
        protected int $amount,
        protected string $currency,
        protected TransactionStatus $status,
        protected Carbon $date,
        protected string $provider
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }
}
