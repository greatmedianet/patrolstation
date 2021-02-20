<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePumps;
use App\Http\Requests\UpdatePumps;
use App\Models\Pump; 
use App\Models\PumpType; 
use App\Models\Shop; 
use App\Models\Tank; 
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PumpExport;
use App\Imports\PumpImport;

class PumpController extends Controller
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
            $pumps = Pump::all();
        }else{
            $pumps = Pump::where('shop_id', Auth::user()->shop_id)->get();
        }
        
        return view('Admin.pumps.index',compact('pumps'));
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
            $pumpTypes = PumpType::pluck('name', 'id')->toArray();
            $tanks = Tank::pluck('name', 'id')->toArray();

            return view('Admin.pumps.create', compact('shops', 'pumpTypes', 'tanks'));
        }else{
            $shops = Shop::pluck('name', 'id')->toArray();
            $pumpTypes = PumpType::pluck('name', 'id')->toArray();
            $user = auth()->user();
            $tanks = Tank::whereHas('Shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
        
            return view('Admin.pumps.create',compact('shops', 'pumpTypes', 'tanks'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePumps $request)
    { 
        $data = $request->validated();
        if(Auth::user()->is_super_admin != 1){
            $data['shop_id'] = Auth::user()->shop_id;
        }
        Pump::create($data);

        return redirect()->route('pumps.index')->with('success','Pump has created Successfully!');
    }

    public function edit($id)
    {
        if(Auth::user()->is_super_admin == 1){
            $pump = Pump::findOrFail($id);
            $shop = Shop::pluck('name', 'id')->toArray();
            $pumpType = PumpType::pluck('name', 'id')->toArray();
            $tank = Tank::pluck('name', 'id')->toArray();

            return view('Admin.pumps.edit', compact('shop', 'pumpType', 'tank','pump'));
        }else{
            $pump = Pump::findOrFail($id);
            $shop = Shop::pluck('name', 'id')->toArray();
            $pumpType = PumpType::pluck('name', 'id')->toArray();
            $user = auth()->user();
            $tank = Tank::whereHas('Shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
        
            return view('Admin.pumps.edit',compact('shop', 'pumpType', 'tank','pump'));
        }

    }

    public function update(UpdatePumps $request, $id)
    {
        $data = $request->validated();
        $pump = Pump::findOrFail($id);
            if(Auth::user()->is_super_admin != 1){
            $data['shop_id'] = Auth::user()->shop_id;
        }
        $pump->update($data);

        return redirect()->route('pumps.index');
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
        return Excel::download(new PumpExport, 'pumps-collection.xlsx');
    }

    public function fileImport(Request $request) 
    {
        Excel::import(new PumpImport, $request->file('file')->store('temp'));
        return back();
    }

    public function destroy(Pump $pump)
    {
        $pump = Pump::findOrFail($pump->id);

        try {
            $pump->delete();

            return redirect()->route('pumps.index')->with('success','Pump  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Pump has Relations!"]);
        }

    }
}

