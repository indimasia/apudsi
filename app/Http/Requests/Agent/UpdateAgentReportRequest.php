<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentReportRequest extends FormRequest
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
            'title'         => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'lng'           => 'required|numeric',
            'lat'           => 'required|numeric',
            'image'         => 'sometimes|image', // Optional image validation
            'description'   => 'required|string',
            'province_code' => 'required|exists:provinces,kode',
            'city_code'     => 'required|exists:cities,kode,kode_provinsi,'   . $this->province_code,
            'district_code' => 'required|exists:districts,kode,kode_kota,'    . $this->city_code,
            'village_code'  => 'required|exists:villages,kode,kode_kecamatan,' . $this->district_code,
        ];
    }
} 