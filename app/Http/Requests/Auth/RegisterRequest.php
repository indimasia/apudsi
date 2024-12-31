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
            'name'                       => 'required|string|max:255',
            'user_type'                  => 'required|in:seller,user',
            'email'                      => 'required|string|email|unique:users',
            'password'                   => 'required|string|min:8|confirmed',
            'password_confirmation'      => 'required',
            'phone'                      => 'required|string|unique:users|doesnt_start_with:08',
            'gender'                     => 'nullable|in:M,F',
            'province_code'              => 'required|exists:provinces,kode',
            'city_code'                  => 'required|exists:cities,kode,kode_provinsi,'    . $this->province_code,
            'district_code'              => 'required|exists:districts,kode,kode_kota,'     . $this->city_code,
            'village_code'               => 'required|exists:villages,kode,kode_kecamatan,' . $this->district_code,

            'shop'             => 'required_if:user_type,seller|array',
            'shop.name'        => 'required_if:user_type,seller|string|max:255',
            'shop.type'        => 'required_if:user_type,seller|string|max:255',
            'shop.description' => 'nullable|string',
            'shop.address'     => 'required_if:user_type,seller|string|max:255',
            'shop.logo'        => 'required_if:user_type,seller|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}

