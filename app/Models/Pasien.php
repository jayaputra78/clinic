<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon; 

class Pasien extends MOdel
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nama_kecil',
        'tempat_lahir',
        'tgl_lahir',
        'ibu_kandung',
        'gol_darah',
        'pekerjaan',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'no_handphone',
        'agama',
        'suku',
        'status_kawin',
        'jenis_kelamin',
        'image'
    ];    

    protected $dates = ['tgl_lahir'];
    protected $dateFormat = 'Y-m-d';

        public function getTglLahirAttribute() {
        return Carbon::parse($this->attributes['tgl_lahir'])->translatedFormat('d F Y');
        }

   public function setTglLahirAttribute() {
        $this->attributes['tgl_lahir'] = (new Carbon())->format('Y-m-d');
   }

    public function medik() {
        return $this->hasMany(Medik::class);
    }

}
