<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Exception;
use Carbon\Carbon;

class Invoice extends Model
{
    private $errors;
    
    protected $fillable = [
        'issuer_id',
        'code',
        'date',
        'delivery_cost',
        'to_pay',
        'nip', 
        'name',
        'first_name',
        'last_name',
        'address',
    ];
    
    protected $primarykey = 'code';
    public $incrementing = false;
    
    public function items() {
        return $this->hasMany(Item::class, 'invoice_code', 'code');
    }
    
    public function issuer() {
        return $this->belongsTo(Issuer::class);
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
            'to_pay' => ['required', 'numeric', 'min:0.01'],
            'code' => ['min:9'],
            'nip' => ['min:10', 'max:10', 'required_with:name'],
            'name' => ['required_without:first_name', 'required_without:last_name'],
        ];

        $v = Validator::make($values, $rules);
        
        $isValid = !$v->fails();
        $this->errors = $isValid ? new \Illuminate\Support\MessageBag() : $v->messages();
        
        return $isValid;
    }
}
