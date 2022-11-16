<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doinvoice extends Model
{
        //
        protected $guarded = []; //JANGAN LUPA TAMBAHKAN CODE INI
        //AGAR DAPAT MENYIMPAN DATA KEDALAM TABLE TERKAIT
    
        //DEFINE ACCESSOR
        public function getTaxAttribute()
        {
            //MENDAPATKAN TAX 2% DARI TOTAL HARGA
            return ($this->total * 2) / 100; 
        }
        
        public function getTotalPriceAttribute()
        {
            //MENDAPATKAN TOTAL HARGA BARU YANG TELAH DIJUMLAHKAN DENGAN TAX
            return ($this->total + (($this->total * 2) / 100));
        }
        
        //DEFINE RELATIONSHIPS
        public function supplier()
        {
            //Invoice reference ke table customers
            return $this->belongsTo(Supplier::class);
        }
    
        public function detail()
        {
            //Invoice memiliki hubungan hasMany ke table invoice_detail
            return $this->hasMany(Doinvoice_detail::class);
        }
    
        public function warehouse()
        {
            //Invoice reference ke table customers
            return $this->belongsTo(Warehouse::class);
        }
        public function user()
        {
            //Invoice reference ke table customers
            return $this->belongsTo(User::class);
        }
        public function member()
        {
            //Invoice reference ke table customers
            return $this->belongsTo(Member::class);
        }
}
