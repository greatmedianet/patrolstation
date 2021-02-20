<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleHistory; 
use Illuminate\Support\Facades\Auth;

class SaleHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }
    
    public function show(){
        if(Auth::user()->is_super_admin == 1) {
            $sales = SaleHistory::orderBy('created_at', 'desc')->get();

            return view('Admin.sales.saleHistories',compact('sales'));
        }else{
            $sales = SaleHistory::where('shop_id', Auth::user()->shop_id)->orderBy('created_at', 'desc')->get();
            // dd($sales);
            return view('Admin.sales.saleHistories',compact('sales'));
        }
    }
}
