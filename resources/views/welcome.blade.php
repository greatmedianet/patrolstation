<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Patro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            .antialiased{
                background-color: #2980ba;
            }
            .header{
                font-size: 7vw;
                color: white !important;
            }
            .link{
                /*font-size: 3rem;*/
                color: white !important;
            }
        </style>
    </head>

    <body class="antialiased">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center">
                    <h1 class="header text-center mt-5">
                         Great Media IT Solution
                    </h1>
                    <h4 class="text-warning">Enter Your License Key Here</h4>
                    <div class="col-12 text-center mb-4">
                        <input type="" name="">
                    </div>
                    <br>
                       <a href="{{ route('login') }}" class="btn-lg btn-outline btn-success" style="text-decoration: none">Submit</a>
                </div>
            </div>

        </div>
    </body>
    
</html>
