<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon; 

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'kta',
        'name',
        'phone',
        'address',
        'email',
        'pimpinan',
        'saldo',
        'member_id'
    ];  
}
