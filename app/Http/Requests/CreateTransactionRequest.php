<?php

namespace App\Http\Requests;

use App\Enums\TransactionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
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
            'title' => 'string|required',
            'value' => 'integer|required',
            'date' => 'date|required',
            'type' => [
                'required',
                Rule::in(TransactionEnum::TYPE)
            ]
        ];
    }
}
