<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Enum\TransactionStatus;
use Illuminate\Support\Carbon;

/**
 * Class Transaction.
 *
 * @OA\Schema(
 *     description="Transaction model",
 *     title="Transaction"
 * )
 */
final class Transaction
{
    public function __construct(
        /**
         * @OA\Property(
         *     example="d3d29d70-1d25-11e3-8591-034165a3a613",
         *     description="ID of the transaction",
         *     title="ID",
         * )
         * @var string
         */
        protected string $id,
        /**
         * @OA\Property(
         *     example="mohammedarey2@gmail.com",
         *     description="Email of the user",
         *     title="Email",
         * )
         * @var string
         */
        protected string $email,
        /**
         * @OA\Property(
         *     example="300",
         *     format="int32",
         *     description="Amount of the transaction",
         *     title="Amount",
         * )
         * @var string
         */
        protected int $amount,
        /**
         * @OA\Property(
         *     example="USD",
         *     description="Currency of the amount billed with this transaction",
         *     title="Currency",
         * )
         * @var string
         */
        protected string $currency,
        /**
         * @OA\Property(
         *     example="authorized",
         *     description="Status of the transaction available: (authorized, decline, refunded)",
         *     title="Status",
         * )
         * @var string
         */
        protected TransactionStatus $status,
        /**
         * @OA\Property(
         *     example="2023-10-23",
         *     description="Date of the transaction",
         *     title="Date",
         * )
         * @var string
         */
        protected Carbon $date,
        /**
         * @OA\Property(
         *     example="DataProviderX",
         *     description="Payment gateway provider",
         *     title="Provider",
         * )
         * @var string
         */
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
