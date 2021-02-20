<?php

namespace App\Exports;

use App\Models\BusinessType;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class BusinessExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	if(Auth::user()->is_super_admin == 1){
             return BusinessType::all();
        }else{
             return BusinessType::where('shop_id', Auth::user()->shop_id)->get();
        }
    }
}
