@php
$pagename='Edit Counters';
@endphp
@extends('Admin.layouts.default')
@section('belowstyle')
@stop
@section('main')
<div class="page-wrapper">
    <!-- Page Body Start-->
     <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Counters</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{URL('/admin/counters')}}">Counters</a></li>
                       <li class="breadcrumb-item active text-primary"><a>Edit Counters</a></li>
                  </ol>
             </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="page-body-wrapper">
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                         <div class="card">
                            <div class="card-header bg-primary">
                                 <h5><i class="fas fa-edit mr-3"></i>Edit Counters</h5>
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
                                    
                                    <form action="{{route('counters.update',$counter->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Name:</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" value="{{$counter->name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        @if (Auth::user()->is_super_admin == 1)
                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Shop Name:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control col-lg-6" name="shop_id">
                                                <option>Choose Shop</option>
                                                @foreach($shop as $row)
                                                <option value="{{$row->id}}" 
                                                    @if($counter->shop_id == $row->id) 
                                                    {{'selected'}} @endif>{{$row->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <a href="{{route('counters.index')}}" class="btn btn-secondary mr-3">Back </a>
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