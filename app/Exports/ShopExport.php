<?php

namespace App\Exports;

use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShopExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return Shop::all();
        }else{
             return Shop::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}