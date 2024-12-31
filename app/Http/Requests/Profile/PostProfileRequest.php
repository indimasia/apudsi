<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PostProfileRequest extends FormRequest
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
        // if(auth()->user()->hasRole('biro')) {
        //     return [
        //         'name' => 'required|string|max:255',
        //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        //         'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        //         'phone' => 'required|string|doesnt_start_with:08|unique:users,phone,' . auth()->id(),
        //         'biro_code' => 'required|min:3|max:10|unique:biros,code,' . auth()->user()->biro_id,
        //         'owner' => 'required|string|max:255',
        //         'marketing_phone' => 'required|string|doesnt_start_with:08',
        //         'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        //         'province_code' => 'required|exists:provinces,kode',
        //         'city_code' => 'required|exists:cities,kode',
        //         'average_person_per_year' => 'required|integer',
        //     ];
        // } else {
            return [
                'nik' => ['required', 'string', 'digits:16', 'unique:users,nik,' . auth()->id()],
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
                'gender' => ['required', 'string', 'in:M,F'],
                'phone' => ['required', 'string', 'max:15'],
                'province_code' => ['required', 'string', 'exists:provinces,kode'],
                'city_code' => ['required', 'string', 'exists:cities,kode,kode_provinsi,' . $this->province_code],
                'district_code' => ['required', 'string', 'exists:districts,kode,kode_kota,' . $this->city_code],
                'village_code' => ['required', 'string', 'exists:villages,kode,kode_kecamatan,' . $this->district_code],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ];
        // }
    }
}
