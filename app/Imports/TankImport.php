<?php

namespace App\Imports;

use App\Models\Tank;
use Maatwebsite\Excel\Concerns\ToModel;

class TankImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tank([
            'name' => $row[0],
            'shop_id' => $row[1],
            'fuel_type_id'  => $row[2],
            'max_quantities' => $row[3],
            'current_quantities' => $row[4]
        ]);
    }
}
