<?php

namespace App\Http\Requests\BiroArticles;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiroArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('biro');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail' => 'required|image',
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'excerpt' => 'nullable|string',
        ];
    }
}
