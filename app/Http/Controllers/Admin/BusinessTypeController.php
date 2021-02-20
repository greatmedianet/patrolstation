<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessType; 
use App\Http\Requests\StoreBusiness;
use App\Http\Requests\UpdateBusiness;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BusinessExport;

class BusinessTypeController extends Controller
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
        $business = BusinessType::all();
        return view('Admin.businesses.index',compact('business'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.businesses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusiness $request)
     { //validation
        $data = $request->validated();
        BusinessType::create($data);
        //return
        return redirect()->route('businesses.index')->with('success','Business has created Successfully!');
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
        return Excel::download(new BusinessExport, 'business-collection.xlsx');
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = BusinessType::findOrFail($id);
        return view('Admin.businesses.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusiness $request, $id)
    {
        // Validation
        $data = $request->validated();
        $business = BusinessType::findOrFail($id);
        $business->update($data);
        return redirect()->route('businesses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessType $business)
    {
        $business = BusinessType::findOrFail($business->id);

        try {
            $business->delete();

            return redirect()->route('businesses.index')->with('success','Business  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Business has Relations!"]);
        }

    }
}
