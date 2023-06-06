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
            'mark' => 'required|string',
            'description' => 'required|string',
            'img' => 'required',
            'max_weight'=>'required',
            'auto_category' => 'required|integer',
            'car_numbers' => 'required|string',
            'service' => 'required|integer',
        ];
    }
}
