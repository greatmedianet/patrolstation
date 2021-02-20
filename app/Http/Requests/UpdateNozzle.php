<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNozzle extends FormRequest
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
            'name' => 'required',
            'pump_id' => 'required|exists:pumps,id',
            'tank_id' => 'required|exists:tanks,id',
            'default_pump_meter' => 'required',
            'pipe_length' => 'required',
        ];
    }
}
