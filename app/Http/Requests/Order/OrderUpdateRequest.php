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
            'driver_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'auto_id' => 'nullable|integer',
            'order_types_id' => 'nullable|integer',
            'service_id' => 'nullable|integer',
            'tel_number' => 'nullable|string',
            'name' => 'nullable|string',
            'address' =>'nullable|string',
            'weight' => 'nullable',
            'total_price' => 'nullable',
            'order_at' => 'nullable',
            'notice' => 'nullable',
            'is_accepted' => 'nullable',
        ];
    }
}
