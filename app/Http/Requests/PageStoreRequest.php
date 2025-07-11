<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            abort(403, "Bu işlem için yetkiniz bulunmamaktadır.");
        }
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
            'title' => 'required|string|max:100',
            'slug' => 'required|string|max:150|unique:pages,slug',
            'content_text' => 'nullable|string',
            'image' => 'nullable|max:2048|mimes:jpg,jpeg,png,webp,avif,svg',
            'blade_id' => 'nullable',
            'category_id' => 'nullable',
            'translation_of' => 'nullable',
            'lang_id' => 'nullable',
        ];
    }
}
