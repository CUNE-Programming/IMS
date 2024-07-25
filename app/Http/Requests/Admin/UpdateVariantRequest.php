<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'max_number_of_teams' => 'required|integer|min:0',
            'average_duration' => 'required|integer|min:0',
            'max_team_size' => 'required|integer|min:1',
            'min_girls' => 'required|integer|min:0',
            'min_boys' => 'required|integer|min:0',
        ];
    }
}
