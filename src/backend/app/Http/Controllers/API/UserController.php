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
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Fetches the users along with their transactions",
     *     operationId="index",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TransactionResource")
     *     ),
     * )
     *
     * @param GetUsersRequest $request
     * @param TransactionInterface $transactionService
     *
     * @return AnonymousResourceCollection
     */
    public function index(
        GetUsersRequest $request,
        TransactionInterface $transactionService
    ): AnonymousResourceCollection {
        $transactions = $transactionService->getTransactions();

        $transactions = $transactionService->filterTransactions(request: $request, transactions: $transactions);

        return TransactionResource::collection(resource: $transactions);
    }
}
