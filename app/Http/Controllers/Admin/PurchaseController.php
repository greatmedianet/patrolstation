<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePurchase;
use App\Http\Requests\UpdatePurchase;
use App\Models\Shop; 
use App\Models\Purchase; 
use App\Models\Product; 
use App\Models\Tank; 
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupplierExport;
use App\Imports\SupplierImport;
use App\Models\SupplierType;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use File;

class PurchaseController extends Controller
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
        if(Auth::user()->is_super_admin == 1){
            $purchases = Purchase::all();
            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
            }

            return view('Admin.purchases.index',compact('purchases', 'from', 'to'));
        }else{
            $purchases = Purchase::where('shop_id', Auth::user()->shop_id)->get();
            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
            }

            return view('Admin.purchases.index',compact('purchases', 'from', 'to'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_super_admin == 1){
            $supplierTypes = SupplierType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name', 'id')->toArray();
            $tanks = Tank::pluck('name', 'id')->toArray();
            $shops = Shop::pluck('name', 'id')->toArray();

            return view('Admin.purchases.create', compact('supplierTypes', 'products', 'tanks', 'shops'));
        }else{
            $supplierTypes = SupplierType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name', 'id')->toArray();
            $tanks = Tank::where('shop_id', auth()->user()->shop_id)
            ->pluck('name', 'id')->toArray();

            return view('Admin.purchases.create', compact('supplierTypes', 'products', 'tanks'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchase $request)
    {
        $data = $request->validated();
        $tank = Tank::where('shop_id', auth()->user()->shop_id)
        ->where('id', $request->Tank_Id)
        ->first();

        if(Auth::user()->is_super_admin != 1){
            $data['Shop_Id'] = Auth::user()->shop_id;
        }else{
            $data['Shop_Id'] = $request->shop_id;
        }

        try {
            if (!empty($request->Qty + $tank->current_quantities  <= $tank->max_quantities)){
                $tank->current_quantities = $tank->current_quantities + $data['Qty'];
                
            }else{
                return redirect()->route('purchases.index')->with('error','Purchase Amount is over tank maximum amount!');
            }
            
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

        Purchase::create($data);
        $tank->save();

        return redirect()->route('purchases.index')->with('success','Purchase has created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_super_admin == 1){
            $purchase = Purchase::find($id);
            $supplierTypes = SupplierType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name', 'id')->toArray();
            $tanks = Tank::pluck('name', 'id')->toArray();
            $shops = Shop::pluck('name', 'id')->toArray();

            return view('Admin.purchases.edit', compact('purchase', 'supplierTypes', 'products', 'tanks', 'shops'));
        }
        else{
            $purchase = Purchase::find($id);
            $supplierTypes = SupplierType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name', 'id')->toArray();
            $tanks = Tank::where('shop_id', auth()->user()->shop_id)
            ->pluck('name', 'id')->toArray();

            return view('Admin.purchases.edit', compact('purchase', 'supplierTypes', 'products', 'tanks'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchase $request, $id)
    {
        $data = $request->validated();

        $supplier = Purchase::findOrFail($id);
        if(Auth::user()->role_id != 1){
            $data['shop_id'] = Auth::user()->shop_id;
        }

        $tank = Tank::where('shop_id', auth()->user()->shop_id)
                    ->where('id', $request->Tank_Id)
                    ->first();
        $purchase = Purchase::where('Shop_Id', auth()->user()->shop_id)
                    ->where('Invoice_No', $request->Invoice_No)
                    ->first();

        if (!empty($request->Qty > $purchase->Qty)) {
            $tank->current_quantities = $tank->current_quantities + ($request->Qty - $purchase->Qty);
        }
        elseif (!empty($request->Qty < $purchase->Qty)){
            $tank->current_quantities = $tank->current_quantities - ($purchase->Qty - $request->Qty);
        }

        $supplier->update($data);
        $tank->save();

        return redirect()->route('purchases.index')->with('success','Purchase has updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileExport() 
    {
        return Excel::download(new SupplierExport, 'suppliers-collection.xlsx');
    } 

    public function fileImport(Request $request) 
    {
        Excel::import(new SupplierImport, $request->file('file')->store('temp'));
        return back();
    }

    public function destroy(Purchase $purchase)
    {
        $purchase = Purchase::findOrFail($purchase->id);

        try {
            $purchase->delete();

            return redirect()->route('purchases.index')->with('success','Purchase  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Purchase has Relations!"]);
        }

    }

    public function szyhPurchaseUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.1)",
                    "Certificate-key" => "CZEGJ-O8KLJ-WUM8Y-ZOVT3",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationPurchaseAPI/201522', [
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

    public function szyhbPurchaseUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.2)",
                    "Certificate-key" => "3MXDO-NR1Y3-84PFK-BRY91",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationPurchaseAPI/201523', [
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

}
