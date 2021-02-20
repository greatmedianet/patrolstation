<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShop extends FormRequest
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
            'name' => 'required|string',
            'short_name' => 'required|string',
            'email' => 'required:email',
            'phone' => 'required:string',
            'address' => 'required|string',
            'confirmed_nozzle' => 'required',
            'photo' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
        ];
    }
}
