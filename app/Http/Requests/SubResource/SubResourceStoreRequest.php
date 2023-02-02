<?php

namespace App\Http\Requests\SubResource;

use Illuminate\Foundation\Http\FormRequest;

class SubResourceStoreRequest extends FormRequest
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
            'title' => 'required|unique:sub_resources|string',
            'description' => 'required|string',
            'examples' => 'required|string',
            'resources' => 'nullable|array'
        ];
    }
}
