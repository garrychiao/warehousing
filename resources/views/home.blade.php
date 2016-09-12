@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/mycompany') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->administrator==false) disabled @endif>公司資訊<br><i class="fa fa-home fa-3x" aria-hidden="true"></i><br>My Company</button></a>
                    <a href="{{ url('/information') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->data_export==false) disabled @endif>資料輸出<br><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i><br>Data Export</button></a>
                    <a href="{{ url('/employee') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->administrator==false) disabled @endif>員工管理<br><i class="fa fa-users fa-3x" aria-hidden="true"></i><br>Employee</button></a>
                    <a href="{{ url('/myImage') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->administrator==false) disabled @endif>產品圖片<br><i class="fa fa-picture-o fa-3x" aria-hidden="true"></i><br>Inv Pictures</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
              <div class="panel-body">
                <a href="{{ url('/customer') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->customer==false) disabled @endif>客戶<br><i class="fa fa-child fa-3x" aria-hidden="true"></i><br>Customer</button></a>
                <a href="{{ url('/inventory') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->inventory==false) disabled @endif>倉儲<br><i class="fa fa-archive fa-3x" aria-hidden="true"></i><br>Inventory</button></a>
                <a href="{{ url('/supplier') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->supplier==false) disabled @endif>供應商<br><i class="fa fa-cart-plus fa-3x" aria-hidden="true"></i><br>Supplier</button></a>
              </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/purchase/create') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->purchase==false) disabled @endif>進貨管理<br><i class="fa fa-cloud-download fa-3x" aria-hidden="true"></i><br>Manage Purchase</button></a>
                    <a href="{{ url('/shippment') }}"><button type="button" class="btn btn-primary btn-raised" @if(Auth::user()->proforma==false && Auth::user()->commercial==false) disabled @endif>出貨管理<br><i class="fa fa-cloud-upload fa-3x" aria-hidden="true"></i><br>Manage Shipment</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
