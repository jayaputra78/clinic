<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rek',
        'bank',
        'no_masuk',
        'no_keluar',
        'saldo',
        'account_id',
        'member_id',
        'level'
    ];    

    public function member()
    {
        //Invoice reference ke table customers
        return $this->belongsTo(Member::class);
    }
}
