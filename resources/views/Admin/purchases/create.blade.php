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
            <h1 class="m-0 text-dark">Purchases</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/admin/purchases')}}">Purchases</a></li>
              <li class="breadcrumb-item active text-dark"><a href="{{URL('/admin/purchases/create')}}">Create Purchase</a></li>
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
                            <h5><i class="fas fa-plus-circle mr-3"></i>Create Purchase</h5>
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

                                    <form action="{{route('purchases.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="Date" class="col-sm-2">Purchase Date:</label>
                                            <div class="col-sm-8">
                                                <input type="datetime-local" name="Date" id="Date" placeholder="Enter Purchase Date" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Invoice_No" class="col-sm-2">Invoice No:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="Invoice_No" id="Invoice_No" placeholder="Enter Invoice Number" class="form-control col-lg-6" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Supplier" class="col-sm-2">Supplier:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="Supplier" id="Supplier" placeholder="Enter Supplier Name" class="form-control col-lg-6" required>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="Supplier_Type" class="col-sm-2">Choose Supplier Type:</label>
                                            <div class="col-sm-8">
                                                <select class="auto-complete form-control col-lg-6" name="Supplier_Type" id="Supplier_Type" value="{{ old('Supplier_Type') }}" required>
                                                    <option value="">Please choose one option</option>
                                                    @foreach($supplierTypes as $key => $value)
                                                    <option value="{{ $key }}" {{ old('Supplier_Type') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Product" class="col-sm-2">Choose Product:</label>
                                            <div class="col-sm-8">
                                                <select class="auto-complete form-control col-lg-6" name="Product" id="Product" value="{{ old('Product') }}" required>
                                                    <option value="">Please choose one option</option>
                                                    @foreach($products as $key => $value)
                                                    <option value="{{ $key }}" {{ old('Product') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Qty" class="col-sm-2">Quantities: (Liters)</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="Number" name="Qty" id="Qty" placeholder="Enter Quantities" class="form-control col-lg-6" required>
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
                                                    <input type="Number" name="Price" id="Price" placeholder="Example 800 Kyats" class="form-control col-lg-6" required>
                                                    <span class="input-group-append">
                                                        <div class="input-group-text bg-transparent">Ks</div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2" for="Tank_Id">Choose Tank:</label>
                                            <div class="col-sm-8" >
                                                <select class="auto-complete form-control col-lg-6" name="Tank_Id" value="{{ old('Tank_Id') }}" required>
                                                    <option value="">Please choose one option</option>
                                                    @foreach($tanks as $key => $value)
                                                    <option value="{{ $key }}" {{ old('Tank_Id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @if (Auth::user()->is_super_admin == 1)
                                        <div class="form-group row">
                                            <label for="Shop_Id" class="col-sm-2">Choose Shop:</label>
                                            <div class="col-sm-8">
                                                <select class="auto-complete form-control col-lg-6" name="Shop_Id" id="Shop_Id" value="{{ old('Shop_Id') }}" required>
                                                    <option value="">Please choose one option</option>
                                                    @foreach($shops as $key => $value)
                                                    <option value="{{ $key }}" {{ old('Shop_Id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-8">
                                                <a href="{{route('purchases.index')}}" class="btn btn-secondary mr-3">Back  </a>
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