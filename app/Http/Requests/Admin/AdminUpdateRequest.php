<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'password' => 'nullable|string|min:8|confirmed',
            'tel_number' => ['nullable','string', 'unique:admins,tel_number','regex:/^(80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$/']
        ];
    }
}
