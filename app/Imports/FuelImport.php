<?php

namespace App\Imports;

use App\Models\FuelType;
use Maatwebsite\Excel\Concerns\ToModel;

class FuelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FuelType([
              'name'     => $row[1],
              'shop_id'  => $row[2],
              'price'   => $row[3]
        ]);
    }
}