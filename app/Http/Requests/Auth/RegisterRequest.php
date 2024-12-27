<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|unique:users',
            'password'          => 'required|string|min:8',
            'phone'             => 'required|string|unique:users|doesnt_start_with:08',
            'gender'            => 'required|in:M,F',
            'province_code'     => 'required|exists:provinces,kode',
            'city_code'         => 'required|exists:cities,kode',
            'district_code'     => 'required',
            'village_code'      => 'required',
        ];
    }
}
