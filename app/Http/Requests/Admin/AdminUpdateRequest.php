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
            'email' => "required|string|unique:admins,email,{$this->id}",
            'tel_number' => ['required','string', "unique:admins,tel_number,{$this->id}",'regex:/^(8)\s(0)(29|25|44|33)\s(\d{3})(\d{2})(\d{2})$/'],

        ];
    }
}
