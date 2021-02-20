<?php

namespace App\Exports;

use App\Models\Counter;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class CounterExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Counter::all();
        }else{
             return Counter::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
