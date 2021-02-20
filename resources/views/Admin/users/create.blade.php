@extends('Admin.layouts.default')


@section('belowstyle')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@stop

@section('main')

<div class="page-wrapper">

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
              <li class="breadcrumb-item active text-dark"><a href="{{URL('/admin/users/create')}}">Create Users</a></li>
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
                            <div class=" card-header bg-primary">
                                 <h5><i class=" fas fa-plus-circle mr-3"></i>Create Users</h5>
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

                                    <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2">Name:</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" placeholder="Enter User Name" class="form-control col-lg-6">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" id="email" placeholder="Enter User Email" class="form-control col-lg-6">
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
                                            <label class="col-sm-2">Choose Roles:</label>
                                            <div class="col-sm-10" >
                                                <select class="auto-complete form-control col-lg-6" name="role_id" value="{{ old('role_id') }}">
                                                    <option value="">Please choose one option</option>
                                                    @foreach($roles as $key => $value)
                                                    <option value="{{ $key }}" {{ old('role_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @if(Auth::user()->is_super_admin == 1)
                                        <div class="form-group row">
                                            <label class="col-sm-2">Choose Shop Name:</label>
                                            <div class="col-sm-10" >
                                                <select class="auto-complete form-control col-lg-6" name="shop_id" value="{{ old('shop_id') }}">
                                                    <option value="">Please choose one option</option>
                                                    @foreach($shops as $key => $value)
                                                    <option value="{{ $key }}" {{ old('shop_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        
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
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});

  function LengthConverter(valNum) {
      document.getElementById("outputliter").innerHTML=valNum*3.78;
  }

</script>

@stop