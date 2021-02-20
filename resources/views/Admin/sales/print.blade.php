<!------ Include the above in your HEAD tag ---------->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style type="text/css">
    small, tr>td, .dis, .total{
        font-size: 38px;
    }
    
    th{
        font-size: 50px;
    }
    h1{
        font-size: 75px;
    }
</style>

<body>
    <div class="container">
        <div class='row'>
            <div class=col-12>
                <a href="{{ url('admin/dashboard') }}" id="printpagebutton1" class="btn btn-outline btn-secondary mt-2 px-3">Back</a>
                <input id="printpagebutton" type="button" value="Print" onclick="printpage()" class="btn btn-outline btn-primary mt-2 px-3 float-sm-right"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <u><h1 class="font-weight-bold">{{$sale->shop->name}}</h1></u>
                <small>{{$sale->shop->address}} </small><br>
                <small>{{$sale->shop->phone}}</small>
            </div>
        </div><br><br>

        <div class="row">
            <div class="col-sm-6 text-left">
                <small>Voc-{{$sale->shop->short_name.$sale->created_at->format('Ymd').str_pad($sale->id, 6, "0", STR_PAD_LEFT)}}</small>
            </div><br>
            <div class="col-sm-6 text-right">
                <small>Date : {{$sale->created_at->format('d-m-Y')}}</small>
            </div>
        </div>
        <hr style="border: 2px solid black">

        <div class="row">
            <div class="col-sm-6 text-left">
                <small>{{$sale->customer_name}}</small>
            </div>
            <div class="col-sm-6 text-right">
                <small>{{$sale->Product->name}}</small>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-6 text-left">
                <small>{{$sale->pump->name}}</small>
            </div>
            <div class="col-sm-6 text-right">
                <small>{{$sale->nozzle->name ?? '-'}}</small>
            </div>
        </div>

        <div class="row text-right">
            <div class="col-sm-12">
                <table class="table table-border">
                    <thead>
                        <tr class="data text-right">
                            <th>Gallon </th>
                            <th>Liter</th>
                            <th>Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data text-right">
                            <td>{{number_format((float)$sale->qty * 0.21996923465436, 2, '.', '')}}</td>
                            <td>{{number_format((float)$sale->qty, 2, '.', '')}}</td>
                            <td>{{$sale->Product->price}}</td>
                            <td>{{($sale->price)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row float-right">
            <div class="col-sm-12 d-flex">
                <div class="dis">Discount : </div>
                <div class="dis"> {{$sale->discount}}</div>
            </div>
        </div><br><br><br>
        <hr style="border: 2px solid black">

        <div class="row float-right">
            <div class="col-sm-12 d-flex">
                <div class="total"> Total amount : </div>
                <div class="total">{{($sale->price == 0) ? ($sale->qty * $sale->Product->price) : ($sale->price -$sale->discount)}}</div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
<script src="{{asset('js.jQuery.print.js')}}"></script>
<script>
        function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        var printButton1 = document.getElementById("printpagebutton1");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        printButton1.style.visibility = 'hidden';
        //Print the page content
        window.print()
        printButton.style.visibility = 'visible';
        printButton1.style.visibility = 'visible';
    }
</script>
</body>
</html>

