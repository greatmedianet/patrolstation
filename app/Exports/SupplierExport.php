<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class SupplierExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
     {
    	if(Auth::user()->is_super_admin == 1){
             return Purchase::all();
        }else{
             return Purchase::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}