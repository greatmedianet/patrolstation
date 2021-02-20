<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdjustment;
use App\Http\Requests\UpdateAdjustment;
use App\Models\Adjustment;
use App\Models\AdjustmentType;
use App\Models\Product;
use App\Models\Tank;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsSuperAdminMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdjustmentExport;
use App\Imports\AdjustmentImport;

class AdjustmentController extends Controller
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
            $adjustments = Adjustment::orderBy('created_at', 'desc')->all();
            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
            }

            return view('Admin.adjustments.index',compact('adjustments', 'from', 'to'));
        }
        
        else{
            $adjustments = Adjustment::where('Shop_id', Auth::user()->shop_id)->orderBy('created_at', 'desc')->get();

            $from = date('Y-m-d');
            if (!empty($request->get('from'))) {
                $from = date('Y-m-d', strtotime($request->from));
            }

            $to = date('Y-m-d');
            if (!empty($request->get('to'))) {
                $to = date('Y-m-d', strtotime($request->to));
            }
            return view('Admin.adjustments.index',compact('adjustments', 'from', 'to'));
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
        $shops = Shop::pluck('name', 'id')->toArray();
        $tanks = Tank::pluck('name','id')->toArray();
        $Product = Product::pluck('name','id')->toArray();
        $Adjustment_Type = AdjustmentType::pluck('name', 'id')->toArray();

        return view('Admin.adjustments.create',compact('Adjustment_Type','Product','tanks','shops'));
    }else{
        $tanks = Tank::where('shop_id', auth()->user()->shop_id)
                            ->pluck('name', 'id')->toArray();
        $Product = Product::pluck('name','id')->toArray();
        $Adjustment_Type = AdjustmentType::pluck('name', 'id')->toArray();

        return view('Admin.adjustments.create',compact('Adjustment_Type','Product','tanks'));
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdjustment $request)
    {
        $data = $request->validated();

        if(Auth::user()->is_super_admin != 1){
            $data['Shop_id'] = Auth::user()->shop_id;
        }

        $tank = Tank::where('id', $request->Tank_id)
                    ->where('shop_id', auth()->user()->shop_id)
                    ->first();

        if (!empty($request->Qty <= $tank->current_quantities)) {
            $tank->current_quantities = $tank->current_quantities - $request->Qty;
            $tank->save();
        }else {
            return redirect()->route('adjustments.create')->with('error','Quantity is  Over than Tank current amount!');
        }

        Adjustment::create($data);

        return view('Admin.adjustments.index')->with('success','Adjustment has created Successfully!');

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

    public function fileExport() 
    {
        return Excel::download(new AdjustmentExport, 'adjustments-collection.xlsx');
    } 

    public function fileImport(Request $request) 
    {
        Excel::import(new AdjustmentImport, $request->file('file')->store('temp'));
        return back();
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
            $adjustment = Adjustment::find($id);
            $AdjustmentType = AdjustmentType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name','id')->toArray();
            $tanks = Tank::pluck('name','id')->toArray();
            $shops = Shop::pluck('name', 'id')->toArray();

            return view('Admin.adjustments.edit', compact('adjustment', 'shops','AdjustmentType','products','tanks'));
        }else{
            $adjustment = Adjustment::find($id);
            $AdjustmentType = AdjustmentType::pluck('name', 'id')->toArray();
            $products = Product::pluck('name','id')->toArray();
            $user = auth()->user();
            $tanks = Tank::where('shop_id', auth()->user()->shop_id)
                            ->pluck('name', 'id')->toArray();
                        
            return view('Admin.adjustments.edit', compact('adjustment', 'AdjustmentType', 'tanks', 'products'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdjustment $request, $id)
    {
        $data = $request->validated();

        $adjustment = Adjustment::findOrFail($id);
        if(Auth::user()->role_id != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }

        $adjustment = Adjustment::where('Shop_id', auth()->user()->shop_id)
                                ->where('Adjustment_No', $request->Adjustment_No)
                                ->first();
        $tank = Tank::where('id', $request->Tank_id)
                    ->where('shop_id', auth()->user()->shop_id)
                    ->first();

        if (!empty($request->Qty > $adjustment->Qty)) {

            $tank->current_quantities = $tank->current_quantities - ($request->Qty - $adjustment->Qty);
            $tank->save();
        }elseif (!empty($request->Qty < $adjustment->Qty)){

            $tank->current_quantities = $tank->current_quantities + ($adjustment->Qty - $request->Qty);
            $tank->save();
        }
        if (!empty($request->Qty >= $tank->current_quantities)){
            return redirect()->route('adjustments.index')->with('error','Adjustment Amount is over Tank Quantity!');
        }
        $adjustment->update($data);

        return redirect()->route('adjustments.index')->with('success','Adjustment has updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adjustment $adjustment)
    {
        $adjustment = Adjustment::findOrFail($adjustment->id);

        try {
            $adjustment->delete();

            return redirect()->route('adjustments.index')->with('success','Adjustment  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Adjustment has Relations!"]);
        }
    }

    public function szyhAdjustmentUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.1)",
                    "Certificate-key" => "CZEGJ-O8KLJ-WUM8Y-ZOVT3",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationAdjustmentAPI/201522', [
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


    public function szyhbAdjustmentUpload(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'headers' =>[
                    "Content-Type" => "multipart/form-data",
                    "Certificate" => "Shwe Zin Yaw(No.2)",
                    "Certificate-key" => "3MXDO-NR1Y3-84PFK-BRY91",
                ],
            ]);

            $response = $client->request("POST", 'https://uatapi.pprd.gov.mm/api/Transaction/StationAdjustmentAPI/201523', [
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
