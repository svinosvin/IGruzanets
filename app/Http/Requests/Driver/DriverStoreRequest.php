<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class DriverStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'first_name' => 'required|string',
            'patronymic' => 'required|string',
            'tel_number' => ['required','string', 'unique:drivers,tel_number','regex:/^(80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$/'],
            'categories' => 'array|nullable',

        ];
    }
}
