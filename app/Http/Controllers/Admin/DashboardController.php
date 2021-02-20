<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale; 
use App\Models\Nozzle; 
use App\Models\Pump;
use App\Models\Tank;
use App\Models\Product;
use App\Models\BusinessType;
use App\Models\Shop; 
use App\Models\Counter;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_super_admin == 1){

            $shops = Shop::pluck('name', 'id')->toArray();
            $productTypes = Product::pluck('name', 'id')->toArray();
            $products = Product::all();
            $businessTypes = BusinessType::pluck('name', 'id')->toArray();
            $counters = Counter::pluck('name', 'id')->toArray();
            $pumps = Pump::pluck('name', 'id')->toArray();
            $nozzles = Nozzle::pluck('name', 'id')->toArray();
            $tanks = Tank::where('shop_id', auth()->user()->shop_id)->get();

            $diesel = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 1)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $premiumDiesel = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 2)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineTwoRon  = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 3)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineFiveRon = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 4)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineSevenRon = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 5)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');

            $dieselLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 1)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $premiumDieselLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 2)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineTwoRonLiter  = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 3)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineFiveRonLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 4)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineSevenRonLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 5)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            // dd($diesel);

            return view('Admin.dashboard',compact('shops', 'productTypes', 'products','businessTypes', 'counters', 'pumps', 'tanks', 'nozzles', 'diesel', 'premiumDiesel', 'nineTwoRon', 'nineFiveRon', 'nineSevenRon', 'dieselLiter', 'premiumDieselLiter', 'nineTwoRonLiter', 'nineFiveRonLiter', 'nineSevenRonLiter'));
            }

            else{
            $products = Product::where('shop_id', auth()->user()->shop_id)->get();
            $tanks = Tank::where('shop_id', auth()->user()->shop_id)->get();
            $productTypes = Product::where('shop_id', auth()->user()->shop_id)
                                ->pluck('name', 'id')->toArray();
            $businessTypes = BusinessType::pluck('name', 'id')->toArray();
            $counters = Counter::where('shop_id', auth()->user()->shop_id)
                                ->pluck('name', 'id')->toArray();
            $pumps = Pump::where('shop_id', auth()->user()->shop_id)
                                ->pluck('name', 'id')->toArray();
            $user = auth()->user();
            $nozzles = Nozzle::whereHas('pump', function ($query) use($user) {
                            $query->whereHas('shop', function ($query) use($user) {
                            $query->where('id', $user->shop_id);
                        });
                    })->pluck('name', 'id')->toArray();

            $diesel = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 1)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $premiumDiesel = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 2)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineTwoRon  = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 3)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineFiveRon = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 4)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');
            $nineSevenRon = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 5)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('price');

            $dieselLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 1)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $premiumDieselLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 2)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineTwoRonLiter  = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 3)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineFiveRonLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 4)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');
            $nineSevenRonLiter = Sale::where('shop_id', auth()->user()->shop_id)
                            ->where('product', 5)
                            ->whereDate('created_at', Carbon::now())
                            ->get()->sum('qty');

            return view('Admin.dashboard',compact('products', 'tanks', 'productTypes','businessTypes', 'counters', 'pumps', 'nozzles', 'diesel', 'premiumDiesel', 'nineTwoRon', 'nineFiveRon', 'nineSevenRon', 'dieselLiter', 'premiumDieselLiter', 'nineTwoRonLiter', 'nineFiveRonLiter', 'nineSevenRonLiter'));
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $/
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $pump = Pump::pluck('name', 'id')->toArray();
        // $fuels = FuelType::all();
        // $shops = Shop::pluck('name', 'id')->toArray();
        // $nozzle = Nozzle::pluck('name', 'id')->toArray();
        // $sale = Sale::latest()->first();
        // dd($sale);
        
        // return view('Admin.sales.view', compact('sale'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // function to display preview
    public function preview()
    {
        try {
            $sale = Sale::where('shop_id', auth()->user()->shop_id)->latest()->first();

            return view('Admin.sales.view', compact('sale'));
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Error!"]);
        }
    }

    public function generatePDF()
    {
        $sale = Sale::latest()->first();
  
        $pdf = PDF::loadView('Admin.sales.view', compact('sale'));    
        return $pdf->stream('sale.pdf');
    }
}
