<?php

namespace App\Exports;

use App\Models\Pump;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class PumpExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Pump::all();
        }else{
             return Pump::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
