<?php

namespace App\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'string|nullable',
            'first_name' => 'string|nullable',
            'patronymic' => 'string|nullable',
            'tel_number' => ['required','string', 'unique:users,tel_number','regex:/^(8)\s(0)(29|25|44|33)\s(\d{3})(\d{2})(\d{2})$/'],
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'company'=>'nullable|integer'

        ];
    }
}
