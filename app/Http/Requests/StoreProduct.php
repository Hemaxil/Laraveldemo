<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreProduct extends FormRequest
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
            'name'=>'required|max:100',
            'sku'=>'max:45|nullable',
            'short_description'=>'max:100|nullable',
            'long_description'=>'string|nullable',
            'price'=>'regex:/^\d*.?\d{1,2}$/|nullable',
            'special_price'=>'regex:/^\d*.?\d{1,2}$/|nullable|lt:price',
            'meta_title'=>'required|max:45',
            'meta_description'=>'string|nullable',
            'meta_keywords'=>'string|nullable',
            'quantity'=>'integer|nullable',
            'special_price_from'=>'date|date_format:Y-m-d|nullable',
            'special_price_to'=>'date|date_format:Y-m-d|after:special_price_from|nullable'
        ];
    }
    public function messages(){
        return [
            'special_price.lt'=>'Special price must be less than price'
        ];
    }
}
