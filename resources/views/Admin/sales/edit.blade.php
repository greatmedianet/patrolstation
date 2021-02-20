@php
$pagename='Edit Sales';
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
                <h1 class="m-0 text-dark">Sales</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{URL('/admin/sales')}}">Sales</a></li>
                    <li class="breadcrumb-item active text-primary"><a>Edit Sales</a></li>
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
                                <h5><i class="fas fa-edit mr-3"></i>Edit Sales</h5>
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

                                    <form action="{{route('sales.update',$sale->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row">
                                            <label for="invoice_no" class="col-sm-2">Inovice No:</label>
                                            <div class="col-sm-10">
                                                <input name="invoice_no" id="invoice_no" value="{{$sale->invoice_no}}" class="form-control col-lg-6" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="discount" class="col-sm-2">Discount(Kyats):</label>
                                            <div class="col-sm-10">
                                                <input name="discount" id="discount" value="{{$sale->discount}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Business Type:</label>
                                            <div class="col-sm-10">
                                                <select name="business_type" class="form-control col-lg-6" value="{{ old('business_type') }}">
                                                    @foreach ($business_type as $key => $value)
                                                    @if(!empty(old('business_type')) and old('business_type') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="customer_name" class="col-sm-2">Customer Name:</label>
                                            <div class="col-sm-10">
                                                <input name="customer_name" id="customer_name" value="{{$sale->customer_name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Product:</label>
                                            <div class="col-sm-10">
                                                <select name="product" class="form-control col-lg-6" value="{{ old('product') }}">
                                                    @foreach ($products as $key => $value)
                                                    @if(!empty(old('product')) and old('product') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="qty" class="col-sm-2">Quantity:</label>
                                            <div class="col-sm-10">
                                                <input name="qty" id="qty" value="{{$sale->qty}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="discount" class="col-sm-2">Discount(Kyats):</label>
                                            <div class="col-sm-10">
                                                <input name="discount" id="discount" value="{{$sale->discount}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="price" class="col-sm-2">Price(Kyats):</label>
                                            <div class="col-sm-10">
                                                <input name="price" id="price" value="{{$sale->price}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Counter:</label>
                                            <div class="col-sm-10">
                                                <select name="counter_id" class="form-control col-lg-6" value="{{ old('counter_id') }}">
                                                    @foreach ($counters as $key => $value)
                                                    @if(!empty(old('counter_id')) and old('counter_id') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @if (Auth::user()->shop->confirmed_nozzle == 1)
                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Nozzle:</label>
                                            <div class="col-sm-10">
                                                <select name="nozzle_id" class="form-control col-lg-6" value="{{ old('nozzle_id') }}">
                                                    {{-- <option>Please Choose one</option> --}}
                                                    @foreach ($nozzles as $key => $value)
                                                    @if(!empty(old('nozzle_id')) and old('nozzle_id') == $key)
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
                                            <label class="col-sm-2">Choose Pumps:</label>
                                            <div class="col-sm-10">
                                                <select name="pump_id" class="form-control col-lg-6" value="{{ old('pump_id') }}">
                                                    @foreach ($pumps as $key => $value)
                                                    @if(!empty(old('pump_id')) and old('pump_id') == $key)
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
                                                <label class="col-sm-2">Choose Fuel Shop:</label>
                                                <div class="col-sm-10">
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
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <a href="{{route('sales.index')}}" class="btn btn-secondary mr-3">Back </a>
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