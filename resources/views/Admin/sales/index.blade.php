@php
$pagename='Sale List';
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
        <h1 class="m-0 text-dark">Sales</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Sale</a></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-default"> 
    <div class="card-header">
      <div class='row'>
        <div class="col-sm-3">
          <a href="{{ route('saleexport') }}" class="btn btn-outline btn-success">Export</a>
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
          <form action="{{ route('saleimport') }}" method="POST" enctype="multipart/form-data">
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

      <div class="row">
        <div class="col-sm-8">
          <form action="{{route('sale.reports')}}" method="GET" name="search">

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
            <form action="{{ route('szyhsaleupload') }}" method="POST" enctype="multipart/form-data" onSubmit="return confirm('Are you sure to send file?')">
              @csrf
              <div class="form-group float-right d-flex">
                  <div class="custom-file text-left mr-2">
                      <input type="file" accept=".csv" name="excel" class="custom-file-input" id="customFile" required/>
                      <label class="custom-file-label" for="customFile">Choose fiel for server data1</label>
                  </div>
                  <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        @endif

        @if (Auth::user()->is_super_admin == 1 || Auth::user()->shop_id == 2 )
          <div class="col-sm-4 mt-4">
            <form action="{{ route('szyhbsaleupload') }}" method="POST" enctype="multipart/form-data" onSubmit="return confirm('Are you sure to send file?')">
              @csrf
              <div class="form-group float-right d-flex">
                  <div class="custom-file text-left mr-2">
                      <input type="file" accept=".csv" name="excel" class="custom-file-input" id="customFile" required/>
                      <label class="custom-file-label" for="customFile">Choose fiel for server data2</label>
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
  <div class="col-md-12">
      <div class="card card-default">
        <div class="card-body">
          <table id="category" class="table table-bordered table-striped table-responsive">
            <thead class="table bg-primary">
              <tr>
                  <th>No</th>
                  @if (Auth::user()->is_super_admin == 1)
                  <th>Shop Name</th>
                  @endif
                  <th>Date</th>
                  <th>Invoice No</th>
                  <th>Customer Name</th>
                  <th>Business Type</th>
                  <th>Product</th>
                  <th>Pump Name</th>
                  @if (Auth::user()->shop->confirmed_nozzle == 1)
                  <th>Nozzle Name</th>
                  @endif
                  <th>Counter Name</th>
                  <th>Qty (Liter)</th>
                  <th>Discount (Kyat)</th>
                  <th>Price (Kyat)</th>
                  <th>Total Amount</th>
                  <th>Action</th>
              </tr> 
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach ($sales as $row)
                <tr>
                    <td>{{$i++}}</td>
                    @if (Auth::user()->is_super_admin == 1)
                    <td>{{$row->shop->name}}</td>
                    @endif
                    <td>{{$row->date}}</td>
                    <td>{{$row->shop->short_name.$row->created_at->format('Ymd').str_pad($row->id, 6, "0", STR_PAD_LEFT)}}</td>
                    <td>{{$row->customer_name}}</td>
                    <td>{{$row->businessType->name}}</td>
                    <td>{{$row->Product->name}}</td>
                    <td>{{$row->pump->name}}</td>
                    @if (Auth::user()->shop->confirmed_nozzle == 1)
                    <td>{{$row->nozzle->name ?? '-'}}</td>
                    @endif
                    <td>{{$row->counter->name }}</td>
                    <td>{{Str::limit($row->qty, 6)}}</td>
                    <td>{{$row->discount}}</td>
                    <td>{{$row->price}}</td>
                    <td>{{$row->price -$row->discount}}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('sales.edit', $row->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route('sales.test', $row->id)}}">Print</a>
                            <form action="{{ route('sales.destroy', $row->id) }}" method="post" onSubmit="return confirm('Are you sure to delete?')">
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
        <div class="card-footer">
        </div>
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

//   function print(url) {
//     var printWindow = window.open( "sales/test/");
//     printWindow.open();
//     printWindow.print();
//     setTimeout(function () { printWindow.close(); }, 6);
// };
</script>
@stop