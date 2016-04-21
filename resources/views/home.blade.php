@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="/mycompany"><button type="button" class="btn btn-primary btn-raised">公司資訊<br>My Company</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="jumbotron">
              <div class="btn-group btn-group-justified">
                <a href="/customer"><button type="button" class="btn btn-primary btn-raised">客戶<br>Customer</button></a>
                <a href="/inventory"><button type="button" class="btn btn-primary btn-raised">倉儲<br>Inventory</button></a>
                <a href="/supplier"><button type="button" class="btn btn-primary btn-raised">供應商<br>Supplier</button></a>
              </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron">
                <div class="panel-body">
                    <a href="purchase"><button type="button" class="btn btn-primary btn-raised">進貨管理<br>Manage Purchase</button></a>
                    <a href="shippment"><button type="button" class="btn btn-primary btn-raised">出貨管理<br>Manage Shipment</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
