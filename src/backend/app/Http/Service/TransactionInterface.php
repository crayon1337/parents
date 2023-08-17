<?php

namespace App\Http\Service;

use App\Http\Requests\GetUsersRequest;
use Illuminate\Support\Collection;

interface TransactionInterface
{
    /**
     * @return Collection
     */
    public function getTransactions(): Collection;

    /**
     * @param GetUsersRequest $request
     * @param Collection $transactions
     * @return Collection
     */
    public function filterTransactions(GetUsersRequest $request, Collection $transactions): Collection;
}
