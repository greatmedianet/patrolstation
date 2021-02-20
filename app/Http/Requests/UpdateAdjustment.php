<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdjustment extends FormRequest
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
        'Adjustment_Type' => 'required',
        'Product' => 'required',
        'Qty' => 'required',
        'Price' => 'required',
        'Tank_id' => 'required',
        'Shop_id' => 'nullable',
        ];
    }
}
