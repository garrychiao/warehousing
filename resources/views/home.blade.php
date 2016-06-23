@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/mycompany') }}"><button type="button" class="btn btn-primary btn-raised">公司資訊<br>My Company</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
              <div class="panel-body">
                <a href="{{ url('/customer') }}"><button type="button" class="btn btn-primary btn-raised">客戶<br>Customer</button></a>
                <a href="{{ url('/inventory') }}"><button type="button" class="btn btn-primary btn-raised">倉儲<br>Inventory</button></a>
                <a href="{{ url('/supplier') }}"><button type="button" class="btn btn-primary btn-raised">供應商<br>Supplier</button></a>
              </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="{{ url('/purchase/create') }}"><button type="button" class="btn btn-primary btn-raised">進貨管理<br>Manage Purchase</button></a>
                    <a href="{{ url('/shippment') }}"><button type="button" class="btn btn-primary btn-raised">出貨管理<br>Manage Shipment</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
