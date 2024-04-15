<?php

namespace App\Http\Requests\Auths\V2;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|unique:users|doesnt_start_with:08',
            'gender' => 'required|in:M,F',
            'province_code' => 'required|exists:provinces,kode',
            'city_code' => 'required|exists:cities,kode',
        ];
    }
}
