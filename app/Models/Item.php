<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Exception;

class Item extends Model
{
    private $errors;
    
    protected $fillable = [
        'invoice_code',
        'name',
        'description',
        'unit_net_price',
        'unit',
        'quantity',
        'tax',
        'tax_value',
        'total_cost',
    ];
    
    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_code', 'code');
    }
    
    public function save(array $options = array())
    {
        if ($this->isValid())
        {
            parent::save($options);
        }
        else
        {
            $fail = $this->errors->first();
            throw new Exception($fail, 0);
        }
    }
    
    public function isValid()
    {
        $values = $this->getAttributes();
        $rules = [
            
            'tax_value' => [
                function($attribute, $value, $fail) {
                    
                    $expectedTax = round($this->tax * $this->unit_net_price * $this->quantity, 2);
                    
                    if($value != $expectedTax) {
                        $fail(__('Incorrect tax value'));
                    }
                }
            ],
            'total_cost' => ['required', 'numeric', 'min:0.01'],
        ];
        
        $v = Validator::make($values, $rules);
        
        $isValid = !$v->fails();
        $this->errors = $isValid ? new \Illuminate\Support\MessageBag() : $v->messages();
        
        return $isValid;
    }
}
