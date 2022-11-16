<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function account()
    {
        //Invoice reference ke table customers
        return $this->belongsTo(Account::class);
    }
}
