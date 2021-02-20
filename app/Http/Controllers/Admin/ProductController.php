<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Models\Shop; 
use App\Models\Product;
use App\Models\ProductPriceHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsSuperAdminMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FuelExport;
use App\Imports\FuelImport;


class ProductController extends Controller
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
        if(Auth::user()->is_super_admin == 1) {
            $productPrices = Product::all();

        }else{
            $productPrices = Product::where('shop_id', Auth::user()->shop_id)->get();
            
        }

        return view('Admin.products.index', compact('productPrices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::pluck('name', 'id')->toArray();
        
        return view('Admin.products.create',compact('shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    { 
        $data = $request->validated();

        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        Product::create($data);

        $prices = new ProductPriceHistory();
         if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $data['user_id'] = Auth::user()->id;

        $prices->create($data);

        return redirect()->route('products.index')->with('success','Products has created Successfully!');
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
        $shop = Shop::pluck('name', 'id')->toArray();
        $product = Product::findOrFail($id);

        return view('Admin.products.edit', compact('product','shop'));
    }

    public function fileExport() 
    {
        return Excel::download(new FuelExport, 'products-collection.xlsx');
    } 

     public function fileImport(Request $request) 
    {
        Excel::import(new FuelImport, $request->file('file')->store('temp'));
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, $id)
    {
        $data = $request->validated();
        
        $fuel = Product::findOrFail($id);
        if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $fuel->update($data);

        $prices = new ProductPriceHistory();
         if(Auth::user()->is_super_admin != 1){
        $data['shop_id'] = Auth::user()->shop_id;
        }
        $data['user_id'] = Auth::user()->id;

        $prices->create($data);
        
        return redirect()->route('products.index')->with('success','Product Price has update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::findOrFail($product->id);

        try {
            $product->delete();

            return redirect()->route('products.index')->with('success','Products  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "Products has Relations!"]);
        }

    }
}
