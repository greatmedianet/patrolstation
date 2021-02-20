<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTank;
use App\Http\Requests\UpdateTank;
use App\Models\Tank; 
use App\Models\Shop; 
use App\Models\Role; 
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TankExport;
use App\Imports\TankImport;

class TankController extends Controller
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
    public function index()
   {
         if(Auth::user()->is_super_admin == 1){
            $tanks = Tank::all();
        }else{
            $tanks = Tank::where('shop_id', Auth::user()->shop_id)->get();
        }
       
        return view('Admin.tanks.index', compact('tanks'));
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
            $product = Product::pluck('name', 'id')->toArray();

            return view('Admin.tanks.create',compact('shops','product'));
        }else{
            $user = auth()->user();
            $product = Product::whereHas('shop', function ($query) use($user) {
                            $query->where('id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
                        
            return view('Admin.tanks.create',compact('product'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTank $request)
    { 
        $data = $request->validated();
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        Tank::create($data);

        return redirect()->route('tanks.index')->with('success','Tanks has created Successfully!');
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
        return Excel::download(new TankExport, 'tanks-collection.xlsx');
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
            $tank = Tank::findOrFail($id);
            $shop = Shop::pluck('name', 'id')->toArray();
            $product = Product::pluck('name', 'id')->toArray();

            return view('Admin.tanks.edit',compact('shop','product','tank'));
        }else{
            $tank = Tank::findOrFail($id);
            $user = auth()->user();
            $product = Product::whereHas('shop', function ($query) use($user) {
                            $query->where('id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
                        
            return view('Admin.tanks.edit', compact('tank','product','tank'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTank $request, $id)
    {
        $data = $request->validated();
        $tank = Tank::findOrFail($id);
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $tank->update($data);
    
        return redirect()->route('tanks.index')->with('success','tank has update Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank $tank)
    {
        $tank = Tank::findOrFail($tank->id);

        try {
            $tank->delete();

            return redirect()->route('tanks.index')->with('success','Tank  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Tank has Relations!"]);
        }

    }

    public function fileImport(Request $request) 
    {
        Excel::import(new TankImport, $request->file('file')->store('temp'));
        return back();
    }
}
