@php
$pagename='Edit Tanks';
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
                <h1 class="m-0 text-dark">Tanks</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{URL('/admin/tanks')}}">Tanks</a></li>
                      <li class="breadcrumb-item active text-dark">Edit Tanks</li>
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
                                 <h5><i class="fas fa-edit mr-3"></i>Edit Tanks</h5>
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

                                    <form action="{{route('tanks.update',$tank->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')


                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name" value="{{$tank->name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="max_quantities" class="col-sm-2">Maximun Quantities (Liters):</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                <input type="number" name="max_quantities" id="max_quantities" value="{{$tank->max_quantities}}" class="form-control col-lg-6" required>
                                                <span class="input-group-append">
                                                <div class="input-group-text bg-transparent">Liter</div>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="current_quantities" class="col-sm-2">Current Quantities (Liters):</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                <input type="number" name="current_quantities" id="current_quantities" value="{{$tank->current_quantities}}" class="form-control col-lg-6" required>
                                                <span class="input-group-append">
                                                <div class="input-group-text bg-transparent">Liter</div>
                                                </span>
                                                </div>
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
                                            <label class="col-sm-2">Choose Product Type:</label>
                                            <div class="col-sm-10">
                                                <select name="product_id" class="form-control col-lg-6" value="{{ old('product_id') }}">
                                                    @foreach ($product as $key => $value)
                                                    @if(!empty(old('shop_id')) and old('shop_id') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <a href="{{route('tanks.index')}}" class="btn btn-secondary mr-3">Back </a>
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