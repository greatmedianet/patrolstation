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
            <h1 class="m-0 text-dark">Adjustment Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/admin/adjustments')}}">Adjustment Page</a></li>
              <li class="breadcrumb-item active text-dark"><a href="{{URL('/admin/adjustments/create')}}">Create Adjustments</a></li>
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
              <div class=" card-header bg-primary d-flex">
                <div class='col-sm-6'>
                  <h5><i class=" fas fa-plus-circle mr-3"></i>Create Adjustments</h5>
                </div>
                <div class="col-sm-6">
                  @if ($message = Session::get('success')) 
                    <div class="text-success fade show has-icon ml-3">
                      <h5> {{ $message }}</h5>
                    </div> 
                  @endif 
                  @if ($message = Session::get('error')) 
                    <div class="text-white fade show has-icon ml-3"> 
                      <h5> {{ $message }}</h5>
                    </div> 
                  @endif
                </div>
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

                  <form action="{{route('adjustments.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                      <label for="Date" class="col-sm-2">Date:</label>
                      <div class="col-sm-10">
                        <input  type="datetime-local" name="Date" id="Date" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="Adjustment_No" class="col-sm-2">Adjustment No:</label>
                      <div class="col-sm-10">
                        <input type="number" name="Adjustment_No" id="Adjustment_No" placeholder="Enter Adjustment No" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Choose Adjustment Type :</label>
                      <div class="col-sm-10">
                        <select class="auto-complete form-control col-lg-6" name="Adjustment_Type" value="{{ old('Adjustment_Type') }}" required>
                          <option value="">Please choose one option</option>
                          @foreach($Adjustment_Type as $key => $value)
                          <option value="{{ $key }}" {{ old('Adjustment_Type') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Choose Product :</label>
                      <div class="col-sm-10">
                        <select class="auto-complete form-control col-lg-6" name="Product" value="{{ old('Product') }}" required>
                          <option value="">Please choose one option</option>
                          @foreach($Product as $key => $value)
                          <option value="{{ $key }}" {{ old('Product') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="Qty" class="col-sm-2">Quantity:</label>
                      <div class="col-sm-9">
                       <div class="input-group">
                        <input type="number" name="Qty" id="Qty" placeholder="Enter Quantity" class="form-control col-lg-6" required>
                        <span class="input-group-append">
                          <div class="input-group-text bg-transparent">Liter</div>
                        </span>
                      </div>
                    </div>
                  </div>

                    <div class="form-group row">
                      <label for="Price" class="col-sm-2">Price:</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                        <input type="number" name="Price" id="Price" placeholder="Enter Price" class="form-control col-lg-6" required>
                         <span class="input-group-append">
                          <div class="input-group-text bg-transparent">Kyats</div>
                        </span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Choose Tank :</label>
                      <div class="col-sm-10">
                        <select class="auto-complete form-control col-lg-6" name="Tank_id" value="{{ old('Tank_id') }}" required>
                          <option value="">Please choose one option</option>
                          @foreach($tanks as $key => $value)
                          <option value="{{ $key }}" {{ old('Tank_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    @if (Auth::user()->is_super_admin == 1)
                    <div class="form-group row">
                      <label class="col-sm-2">Choose Shop Name:</label>
                      <div class="col-sm-10" >
                        <select class="auto-complete form-control col-lg-6" name="Shop_id" value="{{ old('Shop_id') }}" required>
                          <option value="">Please choose one option</option>
                          @foreach($shops as $key => $value)
                          <option value="{{ $key }}" {{ old('Shop_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    @endif

                    <div class="form-group row">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-10">
                        <a href="{{URL('/admin/adjustments')}}" class="btn btn-secondary mr-3">Back </a>
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
</script>
@stop