<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        $page = $this->route('page');
        $id = $page instanceof \App\Models\Page ? $page->id : $page;

        return [

            'title' => 'required|string|max:255',

            'subtitle' => 'nullable|string|max:255',


            'short_description' => 'nullable|string',

            'description' => 'required|string',

            'meta_title' => 'nullable|string|max:255',

            'meta_keyword' => 'nullable|string|max:255',

            'meta_description' => 'nullable|string',

            'status' => 'nullable|boolean',
        ];
    }
}
