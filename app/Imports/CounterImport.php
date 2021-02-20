<?php

namespace App\Imports;

use App\Models\Counter;
use Maatwebsite\Excel\Concerns\ToModel;

class CounterImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Counter([
            'name' => $row[0],
            'shop_id' => $row[1],
        ]);
    }
}
