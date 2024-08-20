<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isCoordinator();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'season.variant_id' => 'required|exists:variants,id',
            'season.registration_start' => 'required|date|after_or_equal:today',
            'season.registration_end' => 'required|date|after:registration_start',
            'season.start_date' => 'required|date|after:registration_end',
            'season.end_date' => 'required|date|after:start_date',
            'season.description' => 'string|required',
        ];
    }
}
