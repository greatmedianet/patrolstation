<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSale extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'nullable',
            'invoice_no' => 'required',
            'customer_name' => 'required|string',
            'business_type' => 'required|exists:business_types,id',
            'product' => 'required|exists:products,id',
            'pump_id' => 'required|exists:pumps,id',
            'nozzle_id' => 'nullable',
            'counter_id' => 'required|exists:counters,id',
            'qty' => 'nullable',
            'discount' => 'nullable',
            'price' => 'nullable',
            'shop_id' => 'nullable',
        ];
    }
}
