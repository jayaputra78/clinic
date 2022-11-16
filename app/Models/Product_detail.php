<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'satuan',
        'price_j',
        'price_b1',
        'price_b2',
        'price_b3',
        'ppn',
        'diskon',
        'stock',
        'product_id',
        'member_id',
        'jenis'
    ];   

    protected $guarded = []; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
