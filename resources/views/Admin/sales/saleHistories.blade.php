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
        <h1 class="m-0 text-dark">Sale Histories</h1>
      </div><!-- /.col -->

      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/sales-histories')}}">Sale History</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
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
                <th>Editor Name</th>
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
                <td>{{$row->shop->short_name.$row->created_at->format('Ymd').str_pad($row->invoice_no, 6, "0", STR_PAD_LEFT)}}</td>
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
                <td>{{$row->user->name}}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
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
</script>
@stop