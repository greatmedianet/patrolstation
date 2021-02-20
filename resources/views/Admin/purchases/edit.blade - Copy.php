@php
$pagename='Edit Suppliers';
@endphp
@extends('Admin.layouts.default')
@section('belowstyle')
@stop
@section('main')
<div class="page-wrapper">

 <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Suppliers</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/suppliers')}}">Suppliers</a></li>
          <li class="breadcrumb-item active text-primary"><a href="">Edit Suppliers</a></li>
      </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- Page Body Start-->
<div class="page-body-wrapper">
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                          <h5><i class="fas fa-edit mr-3"></i>Edit Suppliers</h5>
                      </div>
                      <div class="card-body">                                  
                        <div class="table-responsive">
                            <div id="basicScenario" class="product-physical"></div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form action="{{route('suppliers.update',$supplier->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2">Supplier Name:</label>
                                        <div class="col-sm-8">
                                            <input name="name" id="name" value="{{$purchase->name}}" class="form-control col-lg-6">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2">Phone:</label>
                                        <div class="col-sm-8">
                                            <input name="phone" id="phone" value="{{$supplier->phone}}" class="form-control col-lg-6">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2">Choose Supplier Type:</label>
                                        <div class="col-sm-8">
                                            <select name="supplier_type" class="form-control col-lg-6" value="{{ old('supplier_type') }}">
                                                @foreach ($supplierTypes as $key => $value)
                                                @if(!empty(old('supplier_type')) and old('supplier_type') == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if (Auth::user()->is_super_admin == 1)
                                    <div class="form-group row">
                                        <label class="col-sm-2">Choose Shop Name:</label>
                                        <div class="col-sm-8">
                                            <select name="shop_id" class="form-control col-lg-6" value="{{ old('shop_id') }}">
                                                @foreach ($shop as $key => $value)
                                                @if(!empty(old('shop_id')) and old('shop_id') == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group row">
                                        <label for="paid_date" class="col-sm-2">Paid Date</label>
                                        <div class="col-sm-8">
                                            <!-- @if(!empty(old('paid_date')))
                                            <input type="date" value="{{ old('paid_date') }}" name="paid_date" class="form-control col-lg-6">
                                            @else
                                            @endif -->
                                            <input type="date" name="paid_date" class="form-control col-lg-6">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Choose Tank:</label>
                                        <div class="col-sm-8">
                                            <select name="tank_id" class="form-control col-lg-6" value="{{ old('tank_id') }}">
                                                @foreach ($tank as $key => $value)
                                                @if(!empty(old('tank_id')) and old('tank_id') == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2">Address:</label>
                                        <div class="col-sm-8">
                                            <input name="address" id="address" value="{{$supplier->address}}" class="form-control col-lg-6">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="quantities" class="col-sm-2">Quantities (Liters):</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input name="quantities" id="quantities" value="{{$supplier->quantities}}" class="form-control col-lg-6" required>
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent">Liter</div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="price_per_liter" class="col-sm-2">Price Per Litre:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input name="price_per_liter" id="price_per_liter" value="{{$supplier->price_per_liter}}" class="form-control col-lg-6">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent">Ks</div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="total_amount" class="col-sm-2">Total Amount:</label>
                                        <div class="col-sm-8">
                                            <input name="total_amount" id="total_amount" value="{{$supplier->total_amount}}" class="form-control col-lg-6">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <a href="{{route('suppliers.index')}}" class="btn btn-secondary mr-3">Back </a>
                                            <input type="submit" value="Save" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>  
</div>
<!-- Page Body Ends-->
</div>
</div>
@endsection
@section('belowscript')
@stop