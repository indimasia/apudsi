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
        if(request('type') == "biro") {
            return [
                'type' => 'required|in:biro,user',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'phone' => 'required|string|unique:users|doesnt_start_with:08',
                'biro_code' => 'required|unique:biros,code|min:3|max:10',
                'owner' => 'required|string|max:255',
                'marketing_phone' => 'required|string|doesnt_start_with:08',
                'logo' => 'required|file|mimes:jpg,jpeg,png|max:1024',
                'province_code' => 'required|exists:provinces,kode',
                'city_code' => 'required|exists:cities,kode',
                'address' => 'required|string',
                'average_person_per_year' => 'required|integer',
            ];
        } else {
            // Individu
            return [
                'type' => 'required|in:biro,user',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'phone' => 'required|string|unique:users|doesnt_start_with:08',
                'gender' => 'required|in:M,F',
                'biro_code' => [
                    'required',
                    Rule::exists('biros', 'code')->where(function (Builder $query) {
                        return $query->where("is_active", true);
                    }),
                ],
                'province_code' => 'required|exists:provinces,kode',
                'city_code' => 'required|exists:cities,kode',
            ];
        }
    }
}
