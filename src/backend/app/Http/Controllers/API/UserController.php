<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\GetUsersRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Service\TransactionInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController
{
    /**
     * @param GetUsersRequest $request
     * @param TransactionInterface $transactionService
     * @return AnonymousResourceCollection
     */
    public function index(
        GetUsersRequest $request,
        TransactionInterface $transactionService
    ): AnonymousResourceCollection {
        $transactions = $transactionService->getTransactions();

        return TransactionResource::collection(resource: $transactions);
    }
}
