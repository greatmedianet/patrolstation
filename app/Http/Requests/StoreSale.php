<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSale extends FormRequest
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
            'invoice_no' => 'nullable',
            'customer_name' => 'required|string',
            'business_type' => 'required|exists:business_types,id',
            'product' => 'required|exists:products,id',
            'pump_id' => 'required|exists:pumps,id',
            'counter_id' => 'required|exists:counters,id',
            'nozzle_id' => 'nullable',
            'qty' => 'required|numeric',
            'discount' => 'required|integer',
            'price' => 'required|integer',
            'shop_id' => 'nullable',
        ];
    }
}
