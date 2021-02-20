<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\Shop; 
use App\Models\Role; 
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSuperAdmin;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->only('destroy');
        $this->middleware('manager')->only(['create', 'edit', 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_super_admin == 1){
            $users = User::all();
        }else{
            $users = User::where('shop_id', Auth::user()->shop_id)->get();
        }

        return view('Admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->is_super_admin == 1) {
            $shops = Shop::pluck('name', 'id')->toArray();
            $roles = Role::pluck('name', 'id')->toArray();

            return view('Admin.users.create',compact('shops','roles'));
        }
        
        $shops = Shop::pluck('name', 'id')->toArray();
        $roles = Role::where('id', '>', Auth::user()->role_id)
                ->pluck('name', 'id')->toArray();
                
        return view('Admin.users.create',compact('shops','roles'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
     { 
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if(Auth::user()->is_super_admin != 1){
            $data['shop_id'] = Auth::user()->shop_id;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success','Users has created Successfully!');
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

    public function fileImport(Request $request) 
    {
        Excel::import(new UsersImport, $request->file('file')->store('temp'));
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
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
      //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);

        try {
            $user->delete();

            return redirect()->route('users.index')->with('success','User  has delete Successfully!');
        }
        catch(\Exception $e) {
            return back()->withErrors(["error" => "User has Relations!"]);
        }

    }
}
