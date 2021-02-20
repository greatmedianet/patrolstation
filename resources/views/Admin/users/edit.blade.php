<!-- <!-- @php
$pagename='Edit Users';
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
                <h1 class="m-0 text-dark">Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{URL('/admin/users')}}">Users</a></li>
                      <li class="breadcrumb-item active text-dark">Edit Users</li>
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
                                 <h5><i class="fas fa-edit mr-3"></i>Edit Users</h5>
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

                                    <form action="{{route('users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Name:</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" value="{{$user->name}}" class="form-control col-lg-6">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2">Email:</label>
                                            <div class="col-sm-10">
                                                <input name="email" id="email" value="{{$user->email}}" class="form-control col-lg-6">
                                            </div>
                                        </div>

                                         <div class="form-group row">
                                            <label for="password" class="col-sm-2">{{ __('Password') }}</label>
                                            <div class="col-sm-5">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-sm-2">{{ __('Confirm Password') }}</label>

                                            <div class="col-sm-5">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Role Name:</label>
                                            <div class="col-sm-10">
                                                <select name="role_id" class="form-control col-lg-6" value="{{ old('role_id') }}">
                                                @foreach ($role as $key => $value)
                                                @if(!empty(old('role_id')) and old('role_id') == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Shop Name:</label>
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

                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <a href="{{route('users.index')}}" class="btn btn-secondary mr-3">Back </a>
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
@stop --> -->