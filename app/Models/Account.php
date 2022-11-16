<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'chart_id',
        'account',
        'keterangan',
        'awal',
        'bulan',
        'akhir',
        'kelompok',
        'akhir1'
    ];  

    public function chart()
    {
        return $this->belongsTo(Chart::class);
    }
}

