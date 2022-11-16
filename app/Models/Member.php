<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    

    protected $fillable = [
        'kta',
        'name',
        'nib',
        'npwp',
        'phone',
        'address',
        'email',
        'pengurus',
        'nilai',
        'biaya'
    ];   
}

