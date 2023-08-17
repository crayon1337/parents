<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\TransactionStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

/**
 * @property int $balanceMin
 */
class GetUsersRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(
                data: [
                    'errors' => $validator->errors()
                ],
                status: ResponseCode::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $minimumBalance = $this->balanceMin + 1;

        return [
            'provider' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', new Enum(type: TransactionStatus::class)],
            'balanceMin' => ['nullable', 'integer', 'min:1'],
            'balanceMax' => ['nullable', 'integer', "min:{$minimumBalance}"],
            'currency' => ['nullable', 'string', 'max:3']
        ];
    }
}
