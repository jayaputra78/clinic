<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon; 

class Harbor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'nama',
        'status',
        'keterangan',
        'member_id'
    ];  

    public function member()
    {
        //Invoice reference ke table customers
        return $this->belongsTo(Member::class);
    }
}
