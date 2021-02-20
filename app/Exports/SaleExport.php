<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Sale::all();
        }else{
             return Sale::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
