<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            # Required проверит не пустое ли значение, пробелы считается пустота!
            'message' => 'required|string',
            # Required - всегда обязательно, чтобы проверка была не на стороне базы изначально, а на PHP что не пустота
            'channel_id' => 'required|exists:channels,id'
        ];
    }
}
