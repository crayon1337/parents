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
     *     @OA\Parameter(
     *         name="provider",
     *         in="query",
     *         required=false,
     *         example="DataProviderX",
     *         description="Payment gateway provider"
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         example="authorized",
     *         description="Status of the transaction. Available: authorized, decline and refunded."
     *     ),
     *     @OA\Parameter(
     *         name="balanceMin",
     *         in="query",
     *         required=false,
     *         example="10",
     *         description="Minimum balance desired. The results will be filtered using this parameter to return the transactions start with the given amount."
     *     ),
     *     @OA\Parameter(
     *         name="balanceMax",
     *         in="query",
     *         required=false,
     *         example="100",
     *         description="Maximum balance desired. The results will be filtered using this parameter to return the transactions end at the given amount."
     *     ),
     *     @OA\Parameter(
     *         name="currency",
     *         in="query",
     *         required=false,
     *         example="USD",
     *         description="The currency will be used to filter results."
     *     ),
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
