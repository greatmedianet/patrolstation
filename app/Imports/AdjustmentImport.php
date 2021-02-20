<?php

namespace App\Imports;

use App\Models\Adjustment;
use Maatwebsite\Excel\Concerns\ToModel;

class AdjustmentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Adjustment([
            'Date'=> $row[0],
            'Adjustment_No'=> $row[1],
            'Adjustment_Type'=> $row[2],
            'Product'=> $row[3],
            'Qty'=> $row[4],
            'Price'=> $row[5],
            'Tank_id'=> $row[6],
            'Shop_id'=> $row[7],
        ]);
    }
}
