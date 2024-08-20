<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
            'teams.*.id' => ['required_without_all:action,postpone_date,postpone_time', 'exists:teams,id'],
            'teams.*.score' => ['required_without_all:action,postpone_date,postpone_time', 'integer'],
        ];
    }
}
