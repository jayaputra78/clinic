<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $fillable = [
        'group_id',
        'chart',
        'keterangan'
    ];  

    public function chartg()
    {
        //Invoice reference ke table customers
        return $this->belongsTo(Chartg::class);
    }
}