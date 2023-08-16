<?php

namespace App\Http\Service;

use Illuminate\Support\Collection;

interface TransactionInterface
{
    /**
     * @return Collection
     */
    public function getTransactions(): Collection;
}
