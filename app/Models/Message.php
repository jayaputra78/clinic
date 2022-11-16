<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_kirim',
        'subject',
        'message'
    ]; 

    public function user()
    {
        //Invoice reference ke table customers
        return $this->belongsTo(User::class);
    }
}
