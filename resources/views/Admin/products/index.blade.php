@php
$pagename='Products';
@endphp
@extends('Admin.layouts.default')
@section('belowstyle')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@stop

@section('main')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Products</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/products')}}">Products</a></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-default"> 
    <div class="card-header row">
      <div class="col-sm-3">
        <a href="{{route('products.create')}}" class="btn btn-outline btn-primary">Add Products</a>
        <a href="{{ route('productexport') }}" class="btn btn-outline btn-success">Export</a>
      </div>

      <div class="col-sm-6 btn btn-outline">
          @if ($message = Session::get('success')) 
            <div class="text-success fade show has-icon ml-3">
              <h5> {{ $message }}</h5>
            </div> 
          @endif 
          @if ($message = Session::get('error')) 
            <div class="text-danger fade show has-icon ml-3"> 
              <h5> {{ $message }}</h5>
            </div> 
          @endif
      </div>

      <div class="col-sm-3">
        <form action="{{ route('productimport') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group float-right d-flex">
            <div class="custom-file text-left mr-2">
              <input type="file" name="file" class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <button class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card card-default">
        <div class="card-body">
          <table id="category" class="table table-bordered table-striped">
              <thead class="table bg-primary">
                <tr>
                  <th>No</th>
                  <th>Product Name</th>
                  @if (Auth::user()->is_super_admin == 1)
                  <th>Shop Name</th>
                  @endif
                  <th>Price</th>
                  <th>Action</th>
                </tr> 
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach ($productPrices as $row)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$row->name}}</td>
                    @if (Auth::user()->is_super_admin == 1)
                    <td>{{$row->shop->name}}</td>
                    @endif
                    <td>{{$row->price}}</td>
                    <td>
                        <div class="dropdown">
                          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{route('products.edit', $row->id)}}">Edit</a>
                              <form action="{{ route('products.destroy', $row->id) }}" method="post" onSubmit="return confirm('Are you sure to delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item btn" type="submit">Delete</button>
                              </form>
                          </div>
                        </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      <div class="card-footer"></div>
    </div>
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
    $("#category").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "print"]
    }).buttons().container().appendTo('#category_wrapper .col-md-6:eq(0)');

  });
</script>
@stop