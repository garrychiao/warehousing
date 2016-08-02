@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <!--<div class="col-sm-12">
        <div class="col-sm-4">
          <a href="{{ url('/mycompany') }}" class="thumbnail">
            <img src="{{ url('/img/system/mycompany.png') }}" alt="...">
          </a>
        </div>
        <div class="col-sm-4">
          <a href="{{ url('/information') }}" class="thumbnail">
            <img src="{{ url('/img/system/data_export.png') }}" alt="...">
          </a>
        </div>
        <div class="col-sm-4">
          <a href="{{ url('/employee') }}" class="thumbnail">
            <img src="{{ url('/img/system/employee.png') }}" alt="...">
          </a>
        </div>
      </div>-->
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/mycompany') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->administrator==false) disabled @endif>公司資訊<br>My Company</button></a>
                    <a href="{{ url('/information') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->data_export==false) disabled @endif>資料輸出<br>Data Export</button></a>
                    <a href="{{ url('/employee') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->administrator==false) disabled @endif>員工管理<br>Employee</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
              <div class="panel-body">
                <a href="{{ url('/customer') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->customer==false) disabled @endif>客戶<br>Customer</button></a>
                <a href="{{ url('/inventory') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->inventory==false) disabled @endif>倉儲<br>Inventory</button></a>
                <a href="{{ url('/supplier') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->supplier==false) disabled @endif>供應商<br>Supplier</button></a>
              </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/purchase/create') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->purchase==false) disabled @endif>進貨管理<br>Manage Purchase</button></a>
                    <a href="{{ url('/shippment') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->proforma==false && Auth::user()->commercial==false) disabled @endif>出貨管理<br>Manage Shipment</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
