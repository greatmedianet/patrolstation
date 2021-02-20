<?php

namespace App\Imports;

use App\Models\Purchase;
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
        return new Purchase([
            'Date' => $row[0],
            'Invoice_No' => $row[1],
            'Supplier' => $row[2],
            'Supplier_Type' => $row[3],
            'Product' => $row[4],
            'Qty' => $row[5],
            'Price' => $row[6],
            'Tank_Id' => $row[7],
            'Shop_Id' => $row[8],
        ]);
    }
}