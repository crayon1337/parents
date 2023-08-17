<?php

namespace App\Http\Resources;

use app\DTO\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     description="List of transaction objects",
 *     title="TransactionResource"
 * )
 */
class TransactionResource extends JsonResource
{
    /**
     * The property below is being used for documentation purposes.
     *
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper of the transaction objects"
     * )
     * @var Transaction[]
     */
    protected array $data;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Transaction $transaction */
        $transaction = $this->resource;

        return [
            'id' => $transaction->getId(),
            'email' => $transaction->getEmail(),
            'amount' => $transaction->getAmount(),
            'currency' => $transaction->getCurrency(),
            'status' => $transaction->getStatus()?->value,
            'date' => $transaction->getDate()->format('Y-m-d'),
            'provider' => $transaction->getProvider()
        ];
    }
}
