<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payinvoice_detail extends Model
{
    protected $guarded = [];

    //DEFINE ACCESSOR
    public function getSubtotalAttribute()
    {
        //NILAI DARI SUBTOTAL ADALAH QTY * PRICE
        return number_format($this->masuk * $this->keluar);
    }

    //DEFINE RELATIONSHIPS
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function payinvoice()
    {
        return $this->belongsTo(Payinvoice::class);
    }

        //DEFINE RELATIONSHIPS
        public function cashier()
        {
            return $this->belongsTo(Cashier::class);
        }

                //DEFINE RELATIONSHIPS
                public function supplier()
                {
                    return $this->belongsTo(Supplier::class);
                }
}
