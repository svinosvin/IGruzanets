<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class DriverUpdateRequest extends FormRequest
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
            'name' => 'nullable|string',
            'first_name' => 'nullable|string',
            'patronymic' => 'nullable|string',
            'tel_number' => ['nullable','string',  "unique:drivers,tel_number,{$this->id}", 'regex:/^(8)\s(0)(29|25|44|33)\s(\d{3})(\d{2})(\d{2})$/'],
            'categories' => 'nullable',
            'img' => 'nullable',

        ];
    }
}
