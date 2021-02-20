<?php

namespace App\Exports;

use App\Models\Nozzle;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class NozzleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
   	{
    	if(Auth::user()->is_super_admin == 1){
             return Nozzle::all();
        }else{
             return Nozzle::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
