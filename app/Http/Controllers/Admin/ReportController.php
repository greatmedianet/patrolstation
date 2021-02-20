<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop; 
use App\Models\Sale; 
use App\Models\Purchase; 
use App\Models\Adjustment; 
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
 	public function salereport(Request $request)
    {
    	$from = date('Y-m-d');
        if (!empty($request->get('from'))) {
            $from = date('Y-m-d', strtotime($request->from));
        }

        $to = date('Y-m-d');
        if (!empty($request->get('to'))) {
            $to = date('Y-m-d', strtotime($request->to));
        }
        $nextDay = date('Y-m-d', strtotime(str_replace('-', '/', $to) . "+1 days"));

        $sales = Sale::whereBetween('created_at', [$from, $nextDay])
        				->where('shop_id', Auth()->user()->shop_id)
        				->get();

     	return view('Admin.reports.salereport', compact('sales', 'from', 'to'));
 	}

 	public function purchasereport(Request $request)
    {
        $from = date('Y-m-d');
        if (!empty($request->get('from'))) {
            $from = date('Y-m-d', strtotime($request->from));
        }

        $to = date('Y-m-d');
        if (!empty($request->get('to'))) {
            $to = date('Y-m-d', strtotime($request->to));
        }
        $nextDay = date('Y-m-d', strtotime(str_replace('-', '/', $to) . "+1 days"));

        $purchases = Purchase::whereBetween('created_at', [$from, $nextDay])
                        ->where('shop_id', Auth()->user()->shop_id)
                        ->get();
        // dd($purchases);

     	return view('Admin.reports.purchasereport', compact('purchases', 'from', 'to'));
 	}


    public function adjustmentreport(Request $request)
    {
        $from = date('Y-m-d');
        if (!empty($request->get('from'))) {
            $from = date('Y-m-d', strtotime($request->from));
        }

        $to = date('Y-m-d');
        if (!empty($request->get('to'))) {
            $to = date('Y-m-d', strtotime($request->to));
        }
        $nextDay = date('Y-m-d', strtotime(str_replace('-', '/', $to) . "+1 days"));

        // dd($nextDay);

        $adjustments  = Adjustment::whereBetween('created_at', [$from, $nextDay])
                        ->where('Shop_id', Auth()->user()->shop_id)
                        ->get();
        // dd($purchases);
        
        return view('Admin.reports.adjustresport', compact('adjustments', 'from', 'to'));
    }
}
