<?php

namespace App\Http\Resources;

use App\Http\Service\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
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
            'status' => $transaction->getStatus()->value,
            'date' => $transaction->getDate()->format('Y-m-d'),
            'provider' => $transaction->getProvider()
        ];
    }
}
