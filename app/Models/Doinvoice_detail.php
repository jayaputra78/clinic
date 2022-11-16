<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doinvoice_detail extends Model
{
    use HasFactory; 
    protected $guarded = [];

    //DEFINE ACCESSOR
    public function getSubtotalAttribute()
    {
        //NILAI DARI SUBTOTAL ADALAH QTY * PRICE
        return number_format($this->qty * $this->price);
    }

    //DEFINE RELATIONSHIPS
    public function product()
    {
        return $this->belongsTo(Product_detail::class);
    }

    public function doinvoice()
    {
        return $this->belongsTo(Doinvoice::class);
    }
}
