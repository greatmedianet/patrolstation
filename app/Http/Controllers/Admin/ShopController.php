<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShop;
use App\Http\Requests\UpdateShop;
use App\Models\Shop;
use Illuminate\Support\Facades\File;
use App\Http\Middleware\IsAdmin;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShopExport;


class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_super_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::orderBy('created_at', 'desc')->get();
        return view('Admin.shops.index',compact('shops'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShop $request)
    { 
        $data = $request->validated(); 

        $photo = $request->photo;
        $PhotoName = uniqid().'_'. $photo->getClientOriginalName();
        $photo->storeAs('public/shops/photo', $PhotoName);
        $data['photo'] = 'storage/shops/photo/' . $PhotoName;
        
        Shop::create($data);
        
        return redirect()->route('shops.index')->with('success','Shop has created Successfully!');
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
    * @return \Illuminate\Support\Collection
    */

    public function fileExport() 
    {
        return Excel::download(new ShopExport, 'shops-collection.xlsx');
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fuelshop = Shop::find($id);

        return view('Admin.shops.edit', compact('fuelshop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShop $request, $id)
    {
        $data = $request->validated();
        $shop = Shop::findOrFail($id);
        
        if($request->hasFile('shops')) {
            $photo = $request->photo;
            
            File::delete('public/shops/photo/'.$photo);
            
            $PhotoName = uniqid().'_'. $photo->getClientOriginalName();
            $photo->storeAs('public/shops/photo', $PhotoName);
            $data['photo'] = 'storage/shops/photo/' . $PhotoName;
        }
        
        $shop->update($data);

        return redirect()->route('shops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $shop = Shop::find($shop->id);

        try {

            $PhotoName = $shop->image;

            File::delete('storage/shops/photo/'.$PhotoName);

            Shop::destroy($shop->id)->with('success','Shop  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Shop has Relations!"])->with('error','Shop has Relations!');
        }

    }
}
