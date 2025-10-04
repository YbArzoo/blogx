<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required','string','max:100'],
            'category_id' => ['required','exists:blog_categories,id'],
            'description' => ['required','string'],
            'thumbnail'   => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'status'      => ['required','in:0,1'],
        ];
    }
}
