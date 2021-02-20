<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdjustment extends FormRequest
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
            
        'Date' => 'required',
        'Adjustment_No' => 'required',
        'Adjustment_Type' => 'required|exists:adjustment_types,id',
        'Product' => 'required|exists:products,id',
        'Qty' => 'required|numeric',
        'Price' => 'required|integer',
        'Tank_id' => 'required|exists:tanks,id',
        'Shop_id' => 'nullable',
        ];
    }
}
