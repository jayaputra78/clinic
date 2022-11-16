<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price_j',
        'price_b',
        'price_j2',
        'ppn',
        'diskon',
        'stock'
    ];  

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
