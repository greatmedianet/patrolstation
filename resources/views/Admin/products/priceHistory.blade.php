@php
$pagename='ProductHistory';
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
        <h1 class="m-0 text-dark">Products Price Histories</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{URL('/admin/price_histories')}}">Product Price Histories</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card card-default">
      <div class="card-body">
        <table id="category" class="table table-bordered table-striped">
          <thead class="table bg-primary">
            <tr>
              <th>No</th>
              <th>Name</th>
              @if(auth()->user()->is_super_admin == 1)
                <th>Shop Name</th>
              @endif
              <th>Acccount Name</th>
              <th>Price</th>
              <th>Update Date</th>
            </tr> 
          </thead>
          <tbody>
            @php $i=1; @endphp
            @foreach ($prices as $row)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$row->name}}</td>
              @if(auth()->user()->is_super_admin == 1)
                <td>{{$row->shop->name}}</td>
              @endif
              <td>{{$row->user->name}}</td>
              <td>{{$row->price}}</td>
              <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
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