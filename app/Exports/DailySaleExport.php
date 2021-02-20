<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Sale;
use Carbon\Carbon;

class DailySaleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::where('shop_id', auth()->user()->shop_id)
                    ->whereDate('created_at', Carbon::now())
                    ->get();
    }
}
