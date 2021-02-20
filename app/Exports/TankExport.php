<?php

namespace App\Exports;

use App\Models\Tank;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class TankExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
   {
    	if(Auth::user()->is_super_admin == 1){
             return Tank::all();
        }else{
             return Tank::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
