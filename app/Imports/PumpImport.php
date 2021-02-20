<?php

namespace App\Imports;

use App\Models\Pump;
use Maatwebsite\Excel\Concerns\ToModel;

class PumpImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pump([
            'name' => $row[0],
            'pump_type' => $row[1],
            'tank_id' => $row[2],
            'shop_id' => $row[3],
        ]);
    }
}
