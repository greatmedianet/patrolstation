<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSale;
use App\Http\Requests\UpdateSale;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale; 
use App\Models\Product;
use App\Models\Nozzle; 
use App\Models\BusinessType; 
use App\Models\Pump;
use App\Models\Tank;
use App\Models\Counter;
use Illuminate\Validation\Rule;
use App\Models\Shop; 
use App\Models\SaleHistory; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaleExport;
use App\Exports\DailySaleExport;
use App\Imports\SaleImport;
use Carbon\Carbon;
use App\Http\Middleware\IsSuperAdminMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager')->only('index');
        $this->middleware('is_admin')->only('create', 'edit', 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->is_super_admin == 1) {
            $sales = Sale::orderBy('created_at', 'DESC')->all();
            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
        }

        }else{
            $sales = Sale::where('shop_id', Auth::user()->shop_id)->orderBy('created_at', 'DESC')->get();
            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
            }
        }
        return view('Admin.sales.index',compact('sales', 'from', 'to'));
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

    public function store(StoreSale $request) 
    {  
        $data = $request->validated();
        $sales = Sale::where('shop_id', auth()->user()->shop_id)->latest()->first();
        $pump = Pump::where('id', $request->pump_id)->first(); 
        $products = Product::where('id', $data['product'])
                            ->where('shop_id', auth()->user()->shop_id)
                            ->get();
        foreach ($products as $key => $value)

        $sale = new Sale();
        $sale->date = Carbon::now();
        
        if ($sales == null) {
            $sale->invoice_no = 1;
        }else{
            $sale->invoice_no = $sales->invoice_no + 1; 
        }
        
        $sale->customer_name = $data['customer_name'];
        $sale->business_type = $data['business_type'];
        $sale->product = $data['product'];
        $sale->pump_id = $data['pump_id'];

        if (!empty($request->nozzle_id != null)) {
            $sale->nozzle_id = $data['nozzle_id'];
        }

        $sale->counter_id = $data['counter_id'];
        $sale->discount = $data['discount'];

        if (!empty($request->qty == 0)) {
            $sale->qty = $request->price/$value->price;
        }else{
            $sale->qty = $data['qty'];
        }

        if (!empty($request->price == 0)) {
           $sale->price = $request->qty * $value->price;
        }else{
            $sale->price = $data['price'];
        }

        if(Auth::user()->is_super_admin != 1){
            $sale->shop_id = Auth::user()->shop_id;
        }else{
            $sale->shop_id = $data['shop_id']; 
        }

        $tank = Tank::where('id', $pump->tank_id)->first();
        try {
            if (!empty($request->qty  <= $tank->current_quantities && $request->qty != 0)){

                $tank->current_quantities = $tank->current_quantities - $request->qty;
            }
            elseif(!empty($request->qty == 0 && $request->price != 0)){

                $tank->current_quantities = $tank->current_quantities - ($request->price/$value->price);
            }
            $tank->save();

        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

        if(!empty($request->nozzle_id != null)){
            $nozzle = Nozzle::where('id', $request->nozzle_id)
                            // ->where('pump_id', $request->pump_id)
                            ->orWhere('tank_id', $request->tank_id)
                            ->first();
            
            try {
                if (!empty($request->qty != 0 && $request->price == 0)){

                    $nozzle->current_pump_meter = $nozzle->current_pump_meter + $request->qty;
                }
                elseif(!empty($request->qty == 0 && $request->price != 0)){

                    $nozzle->current_pump_meter = $nozzle->current_pump_meter + ($request->price/$value->price);
                }
            } catch (Exception $e) {
                \Log::info($e->getMessage());
            }
            $nozzle->save();
        }
        $sale->save();

        return redirect()->route('preview');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->is_super_admin == 1 && Auth::user()->role_id == 1) {
            $saleHistories = SaleHistory::all();
            dd($saleHistories);
        }
        return view('Admin.sales.index',compact('sales'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function fileExport() 
    {
        return Excel::download(new SaleExport, 'sales-collection.xlsx');
    }

    public function dailysaleexport() 
    {
        return Excel::download(new DailySaleExport, 'daily-sales-collection.xlsx');
    } 

    public function fileImport(Request $request) 
    {
        Excel::import(new SaleImport, $request->file('file')->store('temp'));
        return back();
    }

    public function edit($id)
    {
        if(Auth::user()->is_super_admin == 1){
            $sale = Sale::findOrFail($id);
            $products = Product::all();
            $products = Product::pluck('name', 'id')->toArray();
            $business_type = BusinessType::pluck('name', 'id')->toArray();
            $shop = Shop::pluck('name', 'id')->toArray();
            $counters = Counter::pluck('name', 'id')->toArray();
            $pumps = Pump::pluck('name', 'id')->toArray();
            $nozzles = Nozzle::pluck('name', 'id')->toArray();

            return view('Admin.sales.edit',compact( 'shop','products', 'products','business_type', 'counters', 'pumps', 'nozzles','sale'));
            }
            else{
            $sale = Sale::findOrFail($id);
            $sales = Sale::where('shop_id', auth()->user()->shop_id)->get();
            $products = Product::where('shop_id', auth()->user()->shop_id)->get();
            $products = Product::where('shop_id', auth()->user()->shop_id)
                                ->pluck('name', 'id')->toArray();
            $business_type = BusinessType::pluck('name', 'id')->toArray();
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

            return view('Admin.sales.edit',compact('sale','sales', 'products', 'products','business_type', 'counters', 'pumps', 'nozzles'));
        }   

    }

    public function test($id)
    {
        $sale = Sale::findOrFail($id);
        return view('Admin.sales.print',compact('sale'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSale $request, $id)
    {
        $data = $request->validated();
        $pump = Pump::where('id', $request->pump_id)->first(); 
        $product = Product::where('id', $data['product'])
                            ->where('shop_id', auth()->user()->shop_id)
                            ->get();
        foreach ($product as $key => $value)
        
        $sale = Sale::findOrFail($id);
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }

        $tank = Tank::where('id', $pump->tank_id)->first();
        if (!empty($request->qty > $sale->qty)) {
            $tank->current_quantities = $tank->current_quantities - ($request->qty - $sale->qty);
        }
        elseif (!empty($request->qty < $sale->qty)){
            $tank->current_quantities = $tank->current_quantities + ($sale->qty - $request->qty);
        }
        $tank->save();

        if(!empty($request->nozzle_id != null)){
            $nozzle = Nozzle::where('id', $request->nozzle_id)
                            ->orWhere('tank_id', $request->tank_id)
                            ->first();
            if (!empty($request->qty > $sale->qty)) {
                $nozzle->current_pump_meter = $nozzle->current_pump_meter + ($request->qty - $sale->qty);
            }
            elseif (!empty($request->qty < $sale->qty)){
                $nozzle->current_pump_meter = $nozzle->current_pump_meter - ($sale->qty - $request->qty);
            }
            elseif (!empty($request->qty = $sale->qty)){
                $nozzle->current_pump_meter = $request->qty;
            }
        }
        $nozzle->save();
        
        if ($request->qty != $sale->qty && $request->price == $sale->price) {
            $sale->qty = $request->qty;
            $sale->price = $request->qty * $value->price;
        }elseif($request->qty == $sale->qty && $request->price != $sale->price){
            $sale->qty = $request->price/$value->price;
            $sale->price = $data['price'];
        }elseif($request->qty == $sale->qty && $request->price != $sale->price){
            $sale->qty = $request->qty;
            $sale->price = $request->price;
        }else{
            $sale->qty = $request->qty;
            $sale->price = $request->price;
        }  

        $sale->save();

        $saleHistories = new SaleHistory();
        $saleHistories->date = Carbon::now();
        $saleHistories->invoice_no = $data['invoice_no'];
        $saleHistories->customer_name = $data['customer_name'];
        $saleHistories->business_type = $data['business_type'];
        $saleHistories->product = $data['product'];
        $saleHistories->pump_id = $data['pump_id'];

        if (!empty($request->nozzle_id != null)) {
            $saleHistories->nozzle_id = $data['nozzle_id'];
        }

        $saleHistories->counter_id = $data['counter_id'];
        $saleHistories->discount = $data['discount'];
        $saleHistories->qty = $sale->qty;
        $saleHistories->price = $sale->price;

        if(Auth::user()->is_super_admin != 1){
            $saleHistories->shop_id = Auth::user()->shop_id;
            $saleHistories->user_id = Auth::user()->id;
        }else{
            $saleHistories->shop_id = $data['shop_id']; 
            $saleHistories->user_id =  Auth::user()->id; 
        }
        $saleHistories->save();

        return redirect()->route('sales.index')->with('success','Sale has update Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale = Sale::find($sale->id);
        Sale::destroy($sale->id);

        return redirect()->route('sales.index')->with('error','Sale Deleted Successfully!');
    }

    public function szyhSaleUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.1)",
                    "Certificate-key" => "CZEGJ-O8KLJ-WUM8Y-ZOVT3",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationSaleAPI/201522', [
                'multipart' => [
                    [
                        'name'     => 'value',
                        'contents' => fopen($request->file('excel'), 'r'),
                        'filename' => $request->file('excel')->getClientOriginalName(),

                    ],
                    /** Other form fields here, as we can't send form_fields with multipart same time */
                    [
                        'name' => 'form-data',
                        'contents' => json_encode(
                            [
                                'key' => 'file',
                                'value' => $request->file('excel')->getClientOriginalName(),
                            ]
                        )
                    ]
                ]
            ]);
            // $responseData = json_decode($response->getBody(), true);
            // dd($responseData);
        } catch(\Illuminate\Http\Client\RequestException $e){
            \Log::info($e->getMessage());
        }
        return redirect()->route('purchases.index')->with('success','Purchase has send Successfully!');
    }

    public function szyhbSaleUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.2)",
                    "Certificate-key" => "3MXDO-NR1Y3-84PFK-BRY91",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationSaleAPI/201523', [
                'multipart' => [
                    [
                        'name'     => 'value',
                        'contents' => fopen($request->file('excel'), 'r'),
                        'filename' => $request->file('excel')->getClientOriginalName(),

                    ],
                    /** Other form fields here, as we can't send form_fields with multipart same time */
                    [
                        'name' => 'form-data',
                        'contents' => json_encode(
                            [
                                'key' => 'file',
                                'value' => $request->file('excel')->getClientOriginalName(),
                            ]
                        )
                    ]
                ]
            ]);
            // $responseData = json_decode($response->getBody(), true);
            // dd($responseData);
        } catch(\Illuminate\Http\Client\RequestException $e){
            \Log::info($e->getMessage());
        }
        return redirect()->route('purchases.index')->with('success','Purchase has send Successfully!');
    }

    public function dailySale()
    {
        $sales = Sale::where('shop_id', auth()->user()->shop_id)
                    ->whereDate('created_at', Carbon::now())
                    ->get();

        $totalQty = Sale::where('shop_id', auth()->user()->shop_id)
                    ->whereDate('created_at', Carbon::now())
                    ->get()->sum('qty');

        $totalPrice = Sale::where('shop_id', auth()->user()->shop_id)
                    ->whereDate('created_at', Carbon::now())
                    ->get()->sum('price');
        // dd($totalPrice);

        return view('Admin.sales.dailySale', compact('sales', 'totalQty', 'totalPrice'));
    }
}
