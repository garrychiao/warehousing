@extends('layouts.app')

@section('content')
<div class="">
  <div class="col-sm-12">
    <div class="alert alert-success" role="alert">
      倉儲資訊 / Inventory
      <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
      新增 / Add New Inventory
    </div>
    <div class="btn-group btn-group-justified">
      <a href="/inventory"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
    </div>
  </div>
</div>
<div class="col-sm-12">
  @if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  <form class="form" action="{{ url('/inventory')}}" method="post" role="form">
    {!! csrf_field() !!}
    <div class="col-sm-12">
      <h3>商品內容</h3>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">品號</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="item_id" placeholder="Item ID">
      </div>
      <label class="col-sm-1 control-label">類別</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="category" placeholder="Category">
      </div>
      <label class="col-sm-1 control-label">品名</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="item_name" placeholder="Item Name">
      </div>
      <label class="col-sm-1 control-label">圖號</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="graph_id" placeholder="Graph ID">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">規格</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="standard" placeholder="Standard">
      </div>
      <label class="col-sm-1 control-label">條碼</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="barcode" placeholder="Barcode">
      </div>
      <label class="col-sm-1 control-label">單位</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="unit" placeholder="Unit">
      </div>
      <label class="col-sm-1 control-label">安全庫存</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="safety_inventory" placeholder="Safety Inventory">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">商品描述</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="descriptions" placeholder="Descriptions">
      </div>
      <label class="col-sm-1 control-label">備註</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="remark" placeholder="Remark">
      </div>
    </div>
    <div class="col-sm-12">
      <h3>價格區間</h3>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">價格區間1</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price1" placeholder="Price1">
      </div>
      <label class="col-sm-1 control-label">價格區間2</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price2" placeholder="Price2">
      </div>
      <label class="col-sm-1 control-label">價格區間3</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price3" placeholder="Price3">
      </div>
      <label class="col-sm-1 control-label">價格區間4</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price4" placeholder="Price4">
      </div>
      <label class="col-sm-1 control-label">價格區間5</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price5" placeholder="Price5">
      </div>
      <label class="col-sm-1 control-label">價格區間6</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="price6" placeholder="Price6">
      </div>
    </div>
    <input type="hidden" name="inventory" value="0"/>
    <input type="hidden" name ="avg_cost" value="0"/>
    <div class="form-group">
      <div class="col-sm-6">
        <input type="submit" class="btn btn-success btn-raised" value="Submit"/>
      </div>
    </div>
  </form>
</div>

@endsection
