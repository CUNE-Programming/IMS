<?php

namespace App\Http\Requests;

use App\Enums\ClassStanding;
use App\Enums\Gender;
use App\Rules\CuneEmail;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest() or auth()->user()->is_admin;
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
            'email' => ['required', 'email', 'unique:users,email', new CuneEmail],
            'class_standing' => 'required|enum:' . ClassStanding::class,
            'gender' => 'required|enum:' . Gender::class,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.unique' => __('The email has already been taken.'),
            'class_standing.enum' => __('The class standing must be one of ' . implode(', ', ClassStanding::toLabels()) . '.'),
            'gender.enum' => __('The gender must be one of ' . implode(', ', Gender::toLabels()) . '.'),
        ];
    }
}
