@php
$pagename='Sale';
@endphp

@extends('Admin.layouts.default')

@section('belowstyle')

<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
@stop
@section('main')
<div class="page-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h1 class="text-dark">{{ __('message.sale') }}</h1>
                </div>
                <div class="col-md-6">
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
                <div class="col-sm-3 text-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">{{ __('message.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{URL('/admin/sales')}}">{{ __('message.sale') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body-wrapper">
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card m-2">
                        <div class="card-header bg-primary">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5><i class="fas fa-plus-circle mr-3"></i>{{ __('message.Create Sales')}}</h5>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="{{ route('dailysaleexport') }}" class="btn btn-success text-white">Export</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{route('sales.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class='col-10 p-3' style='border: 2px solid black;'>
                                        <div class='row'>
                                            <div class="form-group col-4 mt-2">
                                                <h5>Customer Name</h5>
                                                <div>
                                                    <input type="text" name="customer_name" id="customer_name" placeholder="example YGN/1234" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-4 mt-2">
                                                <h5>Business Types</h5>
                                                <div>
                                                    <select class="form-control" name="business_type" value="{{ old('business_type') }}" required>
                                                        @foreach($businessTypes as $key => $value)
                                                        <option value="{{ $key }}" {{ old('business_type') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-4 mt-2">
                                                <h5>Products</h5>
                                                <div>
                                                    <select class="form-control" name="product" value="{{ old('product') }}" required>
                                                        @foreach($productTypes as $key => $value)
                                                        <option value="{{ $key }}" {{ old('product') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-4 mt-2">
                                                <h5>Pumps</h5>
                                                <div>
                                                    <select class="form-control" name="pump_id" value="{{ old('pump_id') }}" required>
                                                        @foreach($pumps as $key => $value)
                                                        <option value="{{ $key }}" {{ old('pump_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            @if(auth()->user()->shop->confirmed_nozzle == 1)
                                            <div class="form-group col-4 mt-2">
                                                <h5>Nozzles</h5>
                                                <div>
                                                    <select class="form-control" name="nozzle_id" value="{{ old('nozzle_id') }}">
                                                        @foreach($nozzles as $key => $value)
                                                        <option value="{{ $key }}" {{ old('nozzle_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group col-4 mt-2">
                                                <h5>Counters</h5>
                                                <div>
                                                    <select class="form-control" name="counter_id" value="{{ old('counter_id') }}" required>
                                                        @foreach($counters as $key => $value)
                                                        <option value="{{ $key }}" {{ old('counter_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-4 mt-2">
                                                <h5>{{ __('message.Choose Sell Type')}}</h5>
                                                <select id='choose_sell' class="form-control" required>
                                                    <option value="1">Price</option>
                                                    <option value="2">Liter</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-4 mt-2" style="display: none;" id="liter">
                                                <h5>{{ __('message.Quantity: (Liter)')}}</h5>
                                                    <div class="input-group">
                                                        <input type="Number" name="qty" onchange="gbpfunc()" id="GAB" value="0" placeholder="Enter Fuel Quantity with Liter" class="form-control">
                                                        <span class="input-group-append">
                                                            <div class="input-group-text bg-transparent">Liter</div>
                                                        </span>
                                                    </div>
                                            </div>

                                            <div class="form-group col-4 mt-2"  id="price">
                                                <h5>{{ __('message.Quantity: (Price)')}}</h5>
                                                <div class="input-group">
                                                    <input type="Number" name="price" value="0" class="form-control">
                                                    <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent">Ks</div>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-4 mt-2">
                                                <h5>{{ __('message.Discount: (Kyats)')}}</h5>
                                                <div class="input-group">
                                                    <input name="discount" id="discount" value="0" class="form-control">
                                                    <span class="input-group-append">
                                                        <div class="input-group-text bg-transparent">Ks</div>
                                                    </span>
                                                </div>
                                            </div>   

                                            @if(Auth::user()->is_super_admin == 1)
                                            <div class="form-group col-4 mt-2">
                                                <h5>{{ __('message.Shop Name')}}</h5>
                                                <select class="form-control" name="shop_id" value="{{ old('shop_id') }}" required>
                                                    <option value="">Choose Shop</option>
                                                    @foreach($shops as $key => $value)
                                                    <option value="{{ $key }}" {{ old('shop_id') == $key  ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class='col-2 p-3' style='border: 2px solid black;'>
                                        <div class='row'>
                                            <div class="col-sm-12 text-center">
                                                <input type="Reset" value="Reset" class="btn mt-2 btn-danger px-5">
                                                <input type="submit" value="Save & Print" class="btn mt-2 btn-success px-4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-2 d-flex">
                <div class='col-sm-6 card p-3 mr-5'>
                    <table id="products" class="table table-bordered table-striped">
                        <thead class="table bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Fuel Name</th>
                                @if(auth()->user()->is_super_admin == 1)
                                <th>Shop Name</th>
                                @endif
                                <th>Price</th>
                            </tr> 
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($products as $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->is_super_admin == 1)
                                <td>{{$row->shop_id}}</td>
                                @endif
                                <td>{{$row->price}} Kyats</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='col-sm-5 card p-3'>
                    <table id="tanks" class="table table-bordered table-striped">
                        <thead class="table bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Tank Name</th>
                                @if(auth()->user()->is_super_admin == 1)
                                <th>Shop Name</th>
                                @endif
                                <th>Quantity</th>
                            </tr> 
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($tanks as $row)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->is_super_admin == 1)
                                <td>{{$row->shop_id}}</td>
                                @endif
                                <td>{{$row->current_quantities}} liters</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='row m-2'>
                <div class='col-sm-12 card p-3'>
                    <table class="table table-hover">
                        <thead class="table bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Fuel Name</th>
                                <th>Liter</th>
                                <th>Total Amount</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>(500ppm) Diesel</td>
                                <td>{{$dieselLiter ?? '0'}} Liters</td>
                                <td>{{$diesel ?? '0'}} Kyats</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>(50ppm) Premium Diesel</td>
                                <td>{{$premiumDieselLiter ?? '0'}} Liters</td>
                                <td>{{$premiumDiesel ?? '0'}} Kyats</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>92 Ron</td>
                                <td>{{$nineTwoRonLiter ?? '0'}} Liters</td>
                                <td>{{$nineTwoRon ?? '0'}} Kyats</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>95Ron</td>
                                <td>{{$nineFiveRonLiter ?? '0'}} Liters</td>
                                <td>{{$nineFiveRon ?? '0'}} Kyats</td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>97Ron</td>
                                <td>{{$nineSevenRonLiter ?? '0'}} Liters</td>
                                <td>{{$nineSevenRon ?? '0'}} Kyats</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
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
//   

$(document).ready(function(){
    $('#choose_sell').on('change', function() {
        if ( this.value == '1')
        {
        $("#price").show();
    }
    else
    {
        $("#price").hide();
    }
    if ( this.value == '2')
    {
        $("#liter").show();
    }
    else
    {
        $("#liter").hide();
    }
});
});

var gbp, usd;
function init()
{
    gbp = document.getElementById("GAB");
    usd = document.getElementById("USD");
}

function gbpfunc()
{
    usd.value = parseFloat(gbp.value) * 0.264172;
}

function usdfunc()
{
    gbp.value = parseFloat(usd.value) * 3.78541;
}

init();

function print(url) {
    var printWindow = window.open( "preview");
    printWindow.open();
    printWindow.print();
    setTimeout(function () { printWindow.close(); }, 5);
};
</script>
@stop