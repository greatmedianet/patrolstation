@php
$pagename='Edit Adjustments';
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
            <h1 class="m-0 text-dark">Adjustments</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/admin/adjustments')}}">Adjustments</a></li>
              <li class="breadcrumb-item active text-primary"><a href="">Edit Adjustments</a></li>
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
                          <h5><i class="fas fa-edit mr-3"></i>Edit Adjustments</h5>
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
                                <form action="{{route('adjustments.update',$adjustment->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                            <label for="Date" class="col-sm-2">Date:</label>
                                            <div class="col-sm-8">
                                                <input type="datetime-local" name="Date" id="Date" value="{{ old('Date', date('Y-m-d')) }}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Adjustment_No" class="col-sm-2">Adjustment No:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="Adjustment_No" id="Adjustment_No" value="{{$adjustment->Adjustment_No}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Adjustment Type:</label>
                                            <div class="col-sm-8">
                                                <select name="Adjustment_Type" class="form-control col-lg-6" value="{{ old('Adjustment_Type') }}">
                                                    @foreach ($AdjustmentType as $key => $value)
                                                    @if(!empty(old('Adjustment_Type')) and old('Adjustment_Type') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Product:</label>
                                            <div class="col-sm-8">
                                                <select name="Product" class="form-control col-lg-6" value="{{ old('Product') }}">
                                                    @foreach ($products as $key => $value)
                                                    @if(!empty(old('Product')) and old('Product') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Qty" class="col-sm-2">Quantities: (Liters)</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="Number" name="Qty" id="Qty" value="{{$adjustment->Qty}}" class="form-control col-lg-6" required>
                                                    <span class="input-group-append">
                                                        <div class="input-group-text bg-transparent">Liter</div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Price" class="col-sm-2">Price Per Litre: (Kyats)</label>
                                            <div class="col-sm-7">
                                                 <div class="input-group">
                                                    <input type="Number" name="Price" id="Price" value="{{$adjustment->Price}}" class="form-control col-lg-6" required>
                                                    <span class="input-group-append">
                                                        <div class="input-group-text bg-transparent">Kyats</div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Tank:</label>
                                            <div class="col-sm-8">
                                                <select name="Tank_id" class="form-control col-lg-6" value="{{ old('Tank_id') }}">
                                                    @foreach ($tanks as $key => $value)
                                                    @if(!empty(old('Tank_id')) and old('Tank_id') == $key)
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
                                            <label class="col-sm-2">Choose Shop:</label>
                                            <div class="col-sm-8">
                                                <select name="Shop_id" class="form-control col-lg-6" value="{{ old('Shop_id') }}">
                                                    @foreach ($shops as $key => $value)
                                                    @if(!empty(old('Shop_id')) and old('Shop_id') == $key)
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
                                        <div class="col-sm-8">
                                            <a href="{{route('adjustments.index')}}" class="btn btn-secondary mr-3">Back </a>
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