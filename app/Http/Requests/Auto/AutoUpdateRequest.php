<?php

namespace App\Http\Requests\Auto;

use Illuminate\Foundation\Http\FormRequest;

class AutoUpdateRequest extends FormRequest
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
            'mark' => 'nullable|string',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'max_weight'=>'nullable|regex:/^\d{1}(\.\d{2})?$/',
            'auto_category_id' => 'nullable|integer',
        ];
    }
}
