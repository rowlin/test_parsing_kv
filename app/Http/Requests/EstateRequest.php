<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstateRequest extends FormRequest
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
            'deal_type' => 'nullable',
            'float' => 'nullable|numeric',
            'address'=> 'nullable|max:10',
            'float_total' => 'nullable|numeric|max:99',
            'total_area' => 'nullable|numeric|max:999',
            'year' => 'nullable|numeric|max:2020',
            'price' => 'nullable|numeric' ,
            'page' => 'nullable|numeric',
            'perSize'=>'nullable|numeric' ,
        ];
    }
}
