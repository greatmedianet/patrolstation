@php
$pagename='Adjustment List';
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
        <h1 class="m-0 text-dark">Adjustment</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/adjustments')}}">Adjustment</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card">
  <div class="card-default">
    <div class="card-header">
      <div class="row">
          <div class="col-sm-3">
              <a href="{{route('adjustments.create')}}" class="btn btn-outline btn-primary">Add Adjustment</a>
              <a href="{{ route('adjustmentexport') }}" class="btn btn-outline btn-success">Export</a>
            </div>

            <div class="col-sm-5 btn btn-outline">
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

          <div class="col-sm-4">
            <form action="{{ route('adjustmentimport') }}" method="POST" enctype="multipart/form-data">@csrf
              <div class="form-group float-right d-flex">
                  <div class="custom-file text-left mr-2">
                      <input type="file" name="file" class="custom-file-input" id="customFile" required>
                      <label class="custom-file-label" for="customFile">Choose file for import</label>
                  </div>
                  <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
      </div>

      <div class="row d-flex">
        <div class="col-sm-8">
          <form action="{{route('adjustment.reports')}}" method="GET" name="search">

            <label class="col-sm-3 col-form-label">Enter the from date.<br />
              <input type="date" name="from" class="form-control" value="">
            </label>

            <label class="col-sm-3 col-form-label">Enter the to date.<br />
              <input type="date" name="to" class="form-control" value="">
            </label>

            <button type="submit" class="col-sm-2 col-form-label btn btn-primary btn-rounded mb-1">Search</button>
          </form>
        </div>

        @if (Auth::user()->is_super_admin == 1 || Auth::user()->shop_id == 2 )
          <div class="col-sm-4 mt-4">
            <form action="{{ route('szyhadjustmentupload') }}" method="POST" enctype="multipart/form-data" onSubmit="return confirm('Are you sure to send file?')">
              @csrf
              <div class="form-group float-right d-flex">
                  <div class="custom-file text-left mr-2">
                      <input type="file" accept=".csv" name="excel" class="custom-file-input" id="customFile" required/>
                      <label class="custom-file-label" for="customFile">Choose fiel for server data1 </label>
                  </div>
                  <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        @endif

        @if (Auth::user()->is_super_admin == 1 || Auth::user()->shop_id == 2 )
          <div class="col-sm-4 mt-4">
            <form action="{{ route('szyhbadjustmentupload') }}" method="POST" enctype="multipart/form-data" onSubmit="return confirm('Are you sure to send file?')">
              @csrf
              <div class="form-group float-right d-flex">
                  <div class="custom-file text-left mr-2">
                      <input type="file" accept=".csv" name="excel" class="custom-file-input" id="customFile" required/>
                      <label class="custom-file-label" for="customFile">Choose fiel for server data</label>
                  </div>
                  <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>
<div class="row">
  <!-- col 8 -->
  <div class="col-md-12">
    <div class="card card-default">
      <div class="card-body">
          <table id="category" class="table table-bordered table-striped">
          <thead class="table bg-primary">
            <tr>
              <th>No</th>
              <th>Date</th>
              <th>Adjustment No</th>
              <th>Adjustment Type</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Tank Name</th>
              <th>Total Amount</th>
              @if (Auth::user()->is_super_admin == 1)
              <th>Shop Name</th>
              @endif
              <th>Action</th>
            </tr> 
          </thead>
          <tbody>
            @php $i=1; @endphp
            @foreach ($adjustments as $row)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$row->Date}}</td>
              <td>{{$row->Adjustment_No}}</td>
              <td>{{$row->AdjustmentType->name}}</td>
              <td>{{$row->Product}}</td>
              <td>{{$row->Qty}} Liters</td>
              <td>{{$row->Price}} Kyasts</td>
              <td>{{$row->Tank->name}}</td>
              <td>{{$row->Qty * $row->Price}} Kyasts</td>
              @if (Auth::user()->is_super_admin == 1)
              <td>{{$row->Shop->name}}</td>
              @endif
              <td>
                <div class="dropdown">
                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{route('adjustments.edit', $row->id)}}">Edit</a>
                    <form action="{{ route('adjustments.destroy', $row->id) }}" method="post" onSubmit="return confirm('Are you sure to delete?')">
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
  <!--/End Col 8 -->  
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