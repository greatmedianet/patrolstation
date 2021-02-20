<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNozzle;
use App\Http\Requests\UpdateNozzle;
use App\Models\Nozzle; 
use App\Models\Pump; 
use App\Models\Tank; 
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\NozzleMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NozzleExport;
use App\Imports\NozzleImport;

class NozzleController extends Controller
{
    public function __construct()
    {
        $this->middleware('nozzle');
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
        if (Auth::user()->is_super_admin == 1) {
            $nozzles = Nozzle::all();
        }else{
        $user = auth()->user();
        $nozzles = Nozzle::whereHas('pump', function ($query) use ($user) {
                $query->where('shop_id', $user->shop_id);
            })->get();
        }

        return view('Admin.nozzles.index',compact('nozzles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_super_admin == 1){
            $pumps = Pump::pluck('name', 'id')->toArray();
            $tanks = Tank::pluck('name', 'id')->toArray();

            return view('Admin.nozzles.create', compact('pumps', 'tanks'));
        }else{
            $user = auth()->user();
            $tanks = Tank::whereHas('Shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
            $pumps = Pump::whereHas('shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();

            return view('Admin.nozzles.create',compact('pumps', 'tanks'));
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNozzle $request)
    { 
        $data = $request->validated();

        Nozzle::create($data);
        
        return redirect()->route('nozzles.index')->with('success','Nozzle has created Successfully!');
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
        return Excel::download(new NozzleExport, 'nozzles-collection.xlsx');
    } 

    public function fileImport(Request $request) 
    {
        Excel::import(new NozzleImport, $request->file('file')->store('temp'));
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
            $nozzle = Nozzle::findOrFail($id);
            $pump = Pump::pluck('name', 'id')->toArray();
            $tank = Tank::pluck('name', 'id')->toArray();

            return view('Admin.nozzles.edit', compact('pump', 'tank','nozzle'));
        }else{
            $nozzle = Nozzle::findOrFail($id);
            $user = auth()->user();
            $tank = Tank::whereHas('Shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();
            $pump = Pump::whereHas('shop', function ($query) use($user) {
                            $query->where('shop_id', $user->shop_id);})
                            ->pluck('name', 'id')->toArray();

            return view('Admin.nozzles.edit',compact('pump', 'tank','nozzle'));
        }  

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNozzle $request, $id)
    {
        // Validation
        $data = $request->validated();
        // dd($data);
        $nozzle = Nozzle::findOrFail($id);
        // dd($data);
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $nozzle->update($data);
        // Return
        return redirect()->route('nozzles.index')->with('success','Nozzle has updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nozzle $nozzle)
    {
        $nozzle = Nozzle::findOrFail($nozzle->id);
        
        try {
            $nozzle->delete();

            return redirect()->route('nozzles.index')->with('success','Nozzle  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Nozzle has Relations!"]);
        }

    }
}
