@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="">
        <div class="col-sm-12">
          <div class="alert alert-success" role="alert">
            出貨管理 / Manage Shippment
          </div>
          <div class="btn-group btn-group-justified">
            <a href="/home"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
          </div>
        </div>
        <div class="btn-group btn-group-justified">
          <a href="shippment/proforma/"><button type="button" class="btn btn-primary btn-raised">報價單<br>Proforma Invoice</button></a>
          <a href="shippment/commercial/"><button type="button" class="btn btn-primary btn-raised">出貨單<br>Commercial Invoice</button></a>
        </div>
      </div>
    </div>
</div>
@endsection
