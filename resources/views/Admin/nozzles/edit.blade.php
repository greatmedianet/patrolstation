@php
$pagename='Edit Nozzles';
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
                        <h1 class="m-0 text-dark">Nozzles</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL('/admin/nozzles')}}">Nozzles</a></li>
                            <li class="breadcrumb-item active text-primary"><a>Edit Nozzles</a></li>
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
                                <h5><i class="fas fa-edit mr-3"></i>Edit Nozzles</h5>
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

                                    <form action="{{route('nozzles.update',$nozzle->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Nozzle Name:</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" value="{{$nozzle->name}}" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Pump:</label>
                                            <div class="col-sm-10">
                                                <select name="pump_id" class="form-control col-lg-6" value="{{ old('pump_id') }}">
                                                    @foreach ($pump as $key => $value)
                                                    @if(!empty(old('pump_id')) and old('pump_id') == $key)
                                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Tank:</label>
                                            <div class="col-sm-10">
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
                                            <label for="pipe_length" class="col-sm-2">Origin Pump Meter:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                <input name="default_pump_meter" value="{{$nozzle->default_pump_meter}}" id="default_pump_meter"  class="form-control col-lg-6" required>
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent">Meter</div>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="default_pump_meter" class="col-sm-2">Pump Length:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input name="pipe_length" id="pipe_length" value="{{$nozzle->pipe_length}}" class="form-control col-lg-6" required>
                                                    <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent">Meter</div>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <a href="{{route('nozzles.index')}}" class="btn btn-secondary mr-3">Back </a>
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