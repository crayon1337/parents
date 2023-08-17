<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\GetUsersRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Service\TransactionContract;
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
     *         response=422,
     *         description="Invalid or missing payload",
     *         @OA\JsonContent(
     *             @OA\Examples(example="Unproessable request response", value={
     *                 "errors": {
     *                   "provider": {
     *                     "The provider field must not be greater than 20 characters.",
     *                   }
     *                 },
     *             }, summary="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TransactionResource")
     *     ),
     * )
     *
     * @param GetUsersRequest $request
     * @param TransactionContract $transactionService
     *
     * @return AnonymousResourceCollection
     */
    public function index(
        GetUsersRequest $request,
        TransactionContract $transactionService
    ): AnonymousResourceCollection {
        $transactions = $transactionService->getTransactions();

        $transactions = $transactionService->filterTransactions(request: $request, transactions: $transactions);

        return TransactionResource::collection(resource: $transactions);
    }
}
