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
    <link rel='stylesheet' href='css/fullcalendar.min.css' />

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
    </style>
    <style media="print" type="text/css">
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
        <div class="col-sm-8 col-sm-offset-1">
          <div id='calendar'></div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12">
            <h5><span class="badge" style="background-color:#3BB0EB"><span class="glyphicon glyphicon-record" aria-hidden="true"></span></span> Purchase Records</h5>
            <h5><span class="badge" style="background-color:#f00"><span class="glyphicon glyphicon-record" aria-hidden="true"></span></span> Shipping Records</h5>
          </div>
          <div class="col-sm-12">
            <!-- Modal -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                  </div>
                  <div class="modal-body">
                    <p id="modalInfo">

                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
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

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <!--<script src="{{asset('js/bootstrap.min.js')}}"></script>-->
    <script src="{{asset('js/material.min.js')}}"></script>
    <script src="{{asset('js/ripples.min.js')}}"></script>
    <!--<script src="{{asset('js/photoswipe-ui-default.min.js')}}"></script>
    <script src="{{asset('js/photoswipe.min.js')}}"></script>-->
    <script type="text/javascript">
      $.material.init();
    </script>

    <script src='js/moment.min.js'></script>
    <script src='js/fullcalendar.min.js'></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#calendar').fullCalendar({
          header: { center: 'month,basicWeek' }, // buttons for switching between views
          views: {
              month: { // name of view
                  titleFormat: 'YYYY, MM, DD'
                    // other view-specific options here
              }
          },
          events: [
              @foreach($pur_records as $p)
              {
                title  : 'P_{{$p->order_id}}',
                start  : '{{$p->delivery_date}}',
                color  :  '#3BB0EB',
              },
              @endforeach
              @foreach($com_records as $c)
              {
                title  : 'C_{{$c->order_id}}',
                start  : '{{$c->export_date}}',
                color  :  '#f00',
              },
              @endforeach
          ],
          @if(!Auth::guest())
          eventClick: function(calEvent, jsEvent, view) {
            @foreach($pur_records as $p)
            if(calEvent.title == "P_{{$p->order_id}}"){
              document.getElementById('modalTitle').innerHTML = "{{$p->order_id}}";
              var text="";
              @foreach($pur_inv_records as $key=>$pur_inv)
                @if($p->id == $pur_inv->purchase_records_id)
                text += "<h5>{{$pur_inv->item_id}} - {{$pur_inv->item_name}} : {{$pur_inv->quantity}}</h5>";
                @endif
              @endforeach
              document.getElementById('modalInfo').innerHTML = text;
              $('#modal').modal('show');
            }
            @endforeach
            @foreach($com_records as $c)
            if(calEvent.title == "C_{{$c->order_id}}"){
              document.getElementById('modalTitle').innerHTML = "{{$c->order_id}}";
              var text="";
              @foreach($com_inv_records as $key=>$com_inv)
                @if($c->id == $com_inv->commercial_invoice_id)
                text += "<h5>{{$com_inv->kits_id}}{{$com_inv->item_id}} - {{$com_inv->kits_name}}{{$com_inv->item_name}} : {{$com_inv->quantity}}</h5>";
                @endif
              @endforeach
              document.getElementById('modalInfo').innerHTML = text;
              $('#modal').modal('show');
            }
            @endforeach
          }
          @endif
      })
    });
    </script>
</body>
</html>
