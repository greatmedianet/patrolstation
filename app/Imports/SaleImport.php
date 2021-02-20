<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;

class SaleImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Sale([
        'date' => $row[1],
        'invoice_no'=> $row[2],
        'customer_name'=> $row[3],
        'business_type'=> $row[4],
        'product'=> $row[5],
        'pump_id'=> $row[6],
        'nozzle_id'=> $row[7],
        'counter_id'=> $row[8],
        'qty'=> $row[9],
        'discount'=> $row[10],
        'price'=> $row[11],
        'shop_id'=> $row[12],
        ]);
    }
}
