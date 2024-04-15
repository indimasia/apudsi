<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole("user");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $date = now()->addDays(5)->format("Y-m-d");
        return [
            "name" => ["required", "string", "max:255"],
            'description' => ["nullable", "string", "max:255"],
            "image" => ["nullable", "image", "max:255"],
            "meet_time" => ["required", "date", "before:$date"],
            "meet_location" => ["required", "string", "max:255"],
            "note" => ["nullable", "string"],
        ];
    }
}
