<?php

namespace App\Exports;

use App\Models\Adjustment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdjustmentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Adjustment::all();
        }else{
             return Adjustment::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
