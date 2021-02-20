@php
$pagename='Edit Fuel Shop';
@endphp

@extends('Admin.layouts.default')
@section('belowstyle')

@stop
@section('main')
<div class="page-body-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Fuel Shop Page</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{URL('/admin/shops')}}">Fuel Shop</a></li>
                  <li class="breadcrumb-item active text-primary"><a>Edit Fuel Shop</a></li>
              </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5><i class="fas fa-edit mr-3"></i>Edit Fuel Shops</h5>
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

                                    <form action="{{route('shops.update',$fuelshop->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name" value="{{$fuelshop->name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="short_name" class="col-sm-2">Short Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="short_name" id="short_name" value="{{$fuelshop->short_name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" id="email" value="{{$fuelshop->email}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2">Phone:</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="phone" id="phone" value="{{$fuelshop->phone}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="photo" class="col-sm-2">Photo:</label>
                                            <div class="col-lg-6">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a href="#old" class="nav-link active" data-toggle="tab">Old Photo</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#new" class="nav-link" data-toggle="tab">New Photo</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active mt-3" id="old" role="tabpanel">
                                                        <img src="{{asset($fuelshop->photo)}}" class="img-fluid w-25">
                                                        <input type="hidden" name="oldphoto" value="{{$fuelshop->photo}}">
                                                    </div>

                                                    <div class="tab-pane fade mt-3" id="new" role="tabpanel">
                                                        <input type="file" name="photo" id="photo" accept="images/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2">Address:</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" name="address" id="address" rows="3" class="form-control col-lg-6" required>{{$fuelshop->address}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="confirm_nozzle" class="col-sm-2">Used Nozzle:</label>
                                            <div class="col-sm-10">
                                                <label class="true mr-3">Yes
                                                 <input type="radio" name="confirmed_nozzle" value="1" {{ $fuelshop->confirmed_nozzle == '1' ? 'checked' : '' }}/>
                                             </label> 
                                             <label>No
                                                 <input type="radio" name="confirmed_nozzle" value="0" {{ $fuelshop->confirmed_nozzle == '0' ? 'checked' : '' }}/>
                                             </label>
                                            </div>
                                         <div class="form-group row">
                                            <div class="col-sm-10" style="margin-left: 12rem;">

                                                <a href="{{route('shops.index')}}" class="btn btn-secondary mr-3">Back </a>
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
    </div>
<!-- Container-fluid Ends-->
</div>  
</div>
</div>
@endsection
@section('belowscript')
@stop