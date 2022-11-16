<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'kode',
        'nama',
        'link',
        'status',
        'level1',
        'level2',
        'level3',
        'level4',
        'level5',
        'level6',
        'level7',
        'level8',
        'keterangan'
    ];    
}
