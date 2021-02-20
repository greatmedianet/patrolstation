<?php

namespace App\Imports;

use App\Models\Nozzle;
use Maatwebsite\Excel\Concerns\ToModel;

class NozzleImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Nozzle([
                'name' => $row[0],
                'pump_id' => $row[1],
                'tank_id' => $row[2],
                'default_pump_meter' => $row[3],
                'current_pump_meter' => $row[4],
                'pipe_length' => $row[5]
        ]);
    }
}
