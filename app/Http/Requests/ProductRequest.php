<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255', 'nullable'],
            'unit_price' => ['required', 'numeric', 'min:0.01'],
            'unit' => ['required', 'string', 'max:63'],
            'tax' => ['required', 'numeric', 'min:0.1', 'max:99.9'],
            'id' => ['numeric', 'min:1', 'nullable'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}