<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchase extends FormRequest
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
            // 'Date' => 'nullable',
            'Invoice_No' => 'required|string',
            'Supplier' => 'required|string',
            'Supplier_Type' => 'required|exists:supplier_types,id',
            'Product' => 'required|exists:products,id',
            'Qty' => 'required|numeric',
            'Price' => 'required|integer',
            'Tank_Id' => 'required|exists:tanks,id',
            'Shop_Id' => 'nullable',
        ];
    }
}
