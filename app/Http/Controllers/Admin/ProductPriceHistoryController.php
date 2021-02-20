<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPriceHistory; 
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsSuperAdminMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;

class ProductPriceHistoryController extends Controller
{
    public function __construct()
    {
        // $this->middleware('manager')->only('index');
        $this->middleware('is_admin')->only('show');
    }
    
    public function show(){
        if(Auth::user()->is_super_admin == 1) {
            $prices = ProductPriceHistory::orderBy('created_at', 'desc')->all();

            return view('Admin.products.priceHistory',compact('prices'));
        }else{
            $prices = ProductPriceHistory::where('shop_id', Auth::user()->shop_id)->orderBy('created_at', 'desc')->get();

            return view('Admin.products.priceHistory',compact('prices'));
        }
    }
}
