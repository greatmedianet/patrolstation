@php
$pagename='Adjustment Report';
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
        <h1 class="m-0 text-dark">Adjustments Reports</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Adjustment</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card">
  <div class="card-default"> 
    <div class="card-header">
      <div class="col-sm-12">
        <a href="{{ route('supplierexport') }}" class="btn btn-outline btn-success">Export</a>
        <a href="{{ route('adjustments.index') }}" class="btn btn-outline btn-secondary float-sm-right">Back</a>
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
                  <th>Date</th>
                  <th>Adjustment_No</th>
                  <th>Adjustment_Type</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Price</th>
                </tr> 
              </thead>
              <tbody>
                @foreach ($adjustments as $value)
                <tr>
                  <td>{{$value->Date}}</td>
                  <td>{{$value->Adjustment_No}}</td>
                  <td>{{$value->Adjustment_Type}}</td>
                  <td>{{$value->Product}}</td>
                  <td>{{$value->Qty}}</td>
                  <td>{{$value->Price}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
          </div>
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