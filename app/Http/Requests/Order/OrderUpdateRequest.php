<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'driver_id' => 'nullable',
            'user_id' => 'nullable',
            'car_id' => 'nullable',
            'service_id' => 'nullable',
            'tel_number' => 'nullable',
            'name' => 'nullable',
            'address' =>'nullable',
            'weight' => 'nullable',
            'total_price' => 'nullable',
            'order_at' => 'nullable',
            'notice' => 'nullable',
            'status' => 'nullable',
            'is_accepted' => 'nullable',
        ];
    }
}
