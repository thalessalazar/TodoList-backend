<?php

namespace App\Http\Requests;

use App\Enums\TransactionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string|sometimes',
            'value' => 'numeric|sometimes|regex:/^\d+(\.\d{1,2})?$/',
            'date' => 'date|sometimes',
            'type' => [
                'sometimes',
                Rule::in(TransactionEnum::TYPE)
            ]
        ];
    }
}
