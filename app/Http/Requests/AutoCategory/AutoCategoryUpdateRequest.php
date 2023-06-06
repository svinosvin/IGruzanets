<?php

namespace App\Http\Requests\AutoCategory;

use Illuminate\Foundation\Http\FormRequest;

class AutoCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:auto_categories|string',
            'description' => 'required|string'
        ];
    }
}
