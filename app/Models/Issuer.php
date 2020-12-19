<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuer extends Model
{
    protected $fillable = [
        'nip',
        'name',
        'address',
        'telephone',
    ];
    
    public function invoices() {
        return $this->hasMany(Invoice::class, 'issuer_id');
    }
}
