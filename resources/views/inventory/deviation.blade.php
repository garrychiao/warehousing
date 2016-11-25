@extends('layouts.app')

@section('content')
<div class="">
  <div class="col-sm-12">
    <div class="alert alert-success" role="alert">
      倉儲資訊 / Inventory
      <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
      庫存誤差 / Inventory Deviation
    </div>
    <div class="btn-group btn-group-justified">
      <a href="{{ url('/inventory')}}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
    </div>
  </div>
</div>
<div class="col-sm-12">
  <div class="form-group">
    <form action="{{ url('inventory_deviation') }}" method="post">
      {!! csrf_field() !!}
      <div class="col-sm-1">
        <h4>Item :</h4>
      </div>
      <div class="col-sm-4">
        <select class="form-control" name="inventory_id">
          @foreach($inventory as $key => $inv)
          <option value="{{ $inv->id }}">{{ $inv->item_id}} {{ $inv->item_name}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2">
        <select class="form-control" name="type">
          <option value="minus">減少 / Decrease </option>
          <option value="add">增加 / Increase  </option>
        </select>
      </div>
      <div class="col-sm-1">
        <input class="form-control" type="number" step="1" min="1" name="quantity" value="0">
      </div>
      <div class="col-sm-2">
        <input type="date" class="form-control" name="date" id="date_now" value="">
        <script type="text/javascript">
          var now = new Date();
          var date = new Date(now.setHours(now.getHours()+8));
          document.getElementById('date_now').valueAsDate = date;
        </script>
      </div>
      <div class="col-sm-1">
        <input type="submit" class="btn btn-success btn-raised btn-sm" value="Submit">
      </div>
    </form>
  </div>
  <!--Form Group Ends-->
  <div class="col-sm-12">
    <table class="table table-condensed table-bordered table-hover table-striped">
      <tr>
        <th>ID</th><th>品名 / Item Name</th><th>數量 / Quantity</th><th>日期 / Date</th><th></th>
      </tr>
      @forelse( $deviation as $dev )
      <tr>
        <td>{{$dev->item_id}}</td>
        <td>{{$dev->item_name}}</td>
        <td>{{$dev->deviation}}</td>
        <td>{{$dev->date}}</td>
        <td>
          <form class="form-horizontal" action="inventory_deviation_delete" method="post" role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $dev->id }}">
            <input type="submit" class="btn btn-danger btn-raised btn-sm" value="刪除 / Delete">
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td>無資料 / No data</td>
        <td>無資料 / No data</td>
        <td>無資料 / No data</td>
        <td>無資料 / No data</td>
        <td></td>
      </tr>
      @endforelse
    </table>
  </div>
</div>
@endsection
