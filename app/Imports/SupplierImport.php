<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'nama' => $row[0],
            'alamat' => $row[1],
            'telp' => $row[2],
            'kota' => $row[3],
            'pic' => $row[4],
            'status' => $row[5],
            'total' => $row[6],
            'bayar' => $row[7],
            'saldo' => $row[8],
            'member_id' => $row[9],
        ]);
    }
}
