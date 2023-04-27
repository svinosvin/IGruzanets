<?php

namespace App\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => "required|string|unique:users,email, {$this->id}",
            'name' => 'string|nullable',
            'first_name' => 'string|nullable',
            'patronymic' => 'string|nullable',
            'tel_number' => ['nullable','string','regex:/^(8)\s(0)(29|25|44|33)\s(\d{3})(\d{2})(\d{2})$/'],
            'password' => 'nullable|string|min:8|confirmed',
            'company'=>'nullable|integer'
        ];
    }
}
