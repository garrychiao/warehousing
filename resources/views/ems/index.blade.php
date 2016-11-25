<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Formosan Arsenal</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{asset('css/bootstrap-material-design.min.css')}}" rel="stylesheet">
    <!--<link href="{{asset('css/default-skin.css')}}" rel="stylesheet">
    <link href="{{asset('css/photoswipe.css')}}" rel="stylesheet">-->
    <!--<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">-->
    <link href="{{asset('css/ripples.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <!--Calendar-->
    <link rel='stylesheet' href='{{asset("css/fullcalendar.min.css")}}' />

    <script type="text/javascript">
      function modifyImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#modified_img').attr('src', e.target.result);
              $('#modified_img').attr('width', '200px');
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
      function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#new_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
    <style>
        body {
            font-family: 'Lato';
        }
        .fa-btn {
            margin-right: 6px;
        }
        page {
          /*background: white;*/
          background-image:url({{url('img/ems.jpg')}});
          display: block;
          margin: 0 auto;
          margin-bottom: 0.5cm;
          box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
          padding: 25px 25px 25px 25px;
        }
        page[size="ems"] {
          width: 28.5cm;
          height: 15cm;
        }
        page > img{
          width:100%;
          height:100%;
        }
        @media print {
          table, td, th {
            border: 1px solid black;
          }

          table {
            border-collapse: collapse;
            width: 100%;
          }
          th{
              background-color: #E6E6E6 !important;
              padding: 2px 2px 2px 2px;
          }
          td {
            height: 0px;
            vertical-align: bottom;
            padding: 2px 2px 2px 2px;
          }
          p {
            font-size: 0.1pt;
            font-family:'Times New Roman',Times,serif;
          }
          .label{
            background-color: #E6E6E6 !important;
          }
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Formosan Arsenal
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    @if(Auth::check())
                      <li><a href="{{ url('/customer') }}">Customer</a></li>
                      <li><a href="{{ url('/inventory') }}">Inventory</a></li>
                      <li><a href="{{ url('/supplier') }}">Supplier</a></li>
                      <li><a href="{{ url('/purchase/create') }}">Purchase</a></li>
                      <li><a href="{{ url('/shippment') }}">Shippment</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
    <div class="row">
      <div class="col-md-12">

        <div id="pusher"></div>

        @if(Session::has('message'))
            <div class="alert alert-info">
              {{Session::get('message')}}
            </div>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-success hidden-print" role="alert">
                  國際快捷郵件列印 / Express Mail Service
                </div>
                <div class="btn-group btn-group-justified hidden-print">
                  <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
                </div>
                <div class="col-sm-12">
                  <page size="ems" style="background-image:">
                    hello
                    <!--<img src="{{url('img/ems.jpg')}}" alt="" />-->
                  </page>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
    <!-- JavaScripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>
