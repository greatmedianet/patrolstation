<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCounter;
use App\Http\Requests\UpdateCounter;
use App\Models\Shop; 
use App\Models\Counter; 
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CounterExport;
use App\Imports\CounterImport;

class CounterController extends Controller
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
            $counter = Counter::all();
        }else{
            $counter = Counter::where('shop_id', Auth::user()->shop_id)->get();
        }
        return view('Admin.counters.index',compact('counter'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
   {
        $shops = Shop::pluck('name', 'id')->toArray();

        return view('Admin.counters.create',compact('shops'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCounter $request)
    { 
        $data = $request->validated();
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        Counter::create($data);

        return redirect()->route('counters.index')->with('success','Counters has created Successfully!');
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
        return Excel::download(new CounterExport, 'counters-collection.xlsx');
    } 

    public function fileImport(Request $request) 
    {
        Excel::import(new CounterImport, $request->file('file')->store('temp'));
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
        $shop = Shop::all();
        $counter = Counter::findOrFail($id);
        return view('Admin.counters.edit', compact('shop','counter'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCounter $request, $id)
    {
        $data = $request->validated();
        $counter = Counter::findOrFail($id);
        if(Auth::user()->role_id != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $counter->update($data);

        return redirect()->route('counters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counter $counter)
    {
        $counter = Counter::findOrFail($counter->id);

        try {
            $counter->delete();

            return redirect()->route('counters.index')->with('success','Counter  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Counter has Relations!"]);
        }

    }
}
