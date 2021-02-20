<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class FuelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Product::all();
        }else{
             return Product::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
