<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Exception;

class Product extends Model
{ 
    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'unit',
        'tax',
    ];
}
