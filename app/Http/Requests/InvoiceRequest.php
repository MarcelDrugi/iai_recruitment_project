<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class InvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nip' => ['required_with:name', 'min:10', 'max:10', 'nullable'],
            'name' => ['required_without:first_name', 'required_without:last_name'],
            'first_name' => ['required_without:name'],
            'last_name' => ['required_without:name'],
            'issuer' => ['required'],
            'selectedProduct' => ['required', 'array', 'min:1'],
            'delivery' => ['required', 'numeric', 'min:0', 'nullable'],
        ];
    }
    
    public function messages()
    {
        return [
            'selectedProduct.required' => Lang::get('There is no item on the invoice.'),
        ];
    }

    public function authorize()
    {
        return true;
    }
}