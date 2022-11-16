<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon; 
class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'group_id',
        'jenis'
    ];   

    protected $guarded = []; //JANGAN LUPA TAMBAHKAN CODE INI
    //AGAR DAPAT MENYIMPAN DATA KEDALAM TABLE TERKAIT

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
