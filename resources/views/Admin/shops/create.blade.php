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
          <h1 class="m-0 text-dark">Fuel Shop Page</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{URL('/admin/shops')}}">Fuel Shop</a></li>
            <li class="breadcrumb-item active text-dark"><a href="{{URL('/admin/shops/create')}}">Create Fuel Shop</a></li>
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
                <h5><i class=" fas fa-plus-circle mr-3"></i>Create Fuel Shops</h5>
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

                  <form action="{{route('shops.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                      <label for="name" class="col-sm-2">Name:</label>
                      <div class="col-sm-10">
                        <input type="text" name="name" id="name" placeholder="Enter Shop Name" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="short_name" class="col-sm-2">Short Name:</label>
                      <div class="col-sm-10">
                        <input type="text" name="short_name" id="short_name" placeholder="Enter Shop Short Name" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="email" class="col-sm-2">Email:</label>
                      <div class="col-sm-10">
                        <input type="email" name="email" id="email" placeholder="Enter Shop Email" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="phone" class="col-sm-2">Phone:</label>
                      <div class="col-sm-10">
                        <input  type="number" name="phone" id="phone" placeholder="Enter Shop Phone" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="photo" class="col-sm-2">Image:</label>
                      <div class="col-sm-10">
                        <input type="file" name="photo" id="photo" class="form-control col-lg-6" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="address" class="col-sm-2">Address:</label>
                      <div class="col-sm-10">
                        <textarea  type="text" name="address" id="address" rows="3" placeholder="Enter Fuel Shop Address" class="form-control col-lg-6" required></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="confirm_nozzle" class="col-sm-2">Used Nozzle:</label>
                      <div class="col-sm-10">
                        <label class="true mr-3">Yes
                          <input type="radio" name="confirmed_nozzle" value="1" />
                      </label> 
                      <label>No
                        <input type="radio" name="confirmed_nozzle" value="0" />
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
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