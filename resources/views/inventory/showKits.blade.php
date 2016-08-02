@extends('layouts.app')

@section('content')
<script type="text/javascript">
function showKits(kits_name){
  var table = document.getElementById("selectedTable");
  if(table.rows.length > 1){
    for(var y=table.rows.length ; y > 1 ; y--){
      table.deleteRow(y-1);
    }
  }
  switch(kits_name){

    @foreach($records as $record)
      case "{{ $record->kits_name }}":
      document.getElementById('kits_name').innerHTML = "{{ $record->kits_name }}";
      document.getElementById('kits_id').innerHTML = "{{ $record->kits_id }}";
      document.getElementById('kits_weight').innerHTML = "{{ $record->kits_weight }}";
      document.getElementById('kits_description').innerHTML = "{{ $record->kits_description }}";
      document.getElementById('price1').innerHTML = "{{ $record->price1 }}";
      document.getElementById('price2').innerHTML = "{{ $record->price2 }}";
      document.getElementById('price3').innerHTML = "{{ $record->price3 }}";
      document.getElementById('price4').innerHTML = "{{ $record->price4 }}";
      document.getElementById('price5').innerHTML = "{{ $record->price5 }}";
      document.getElementById('price6').innerHTML = "{{ $record->price6 }}";
      @if(count($records_inv)>0)
        @foreach($records_inv as $rec)
          @if($rec->kits_id == $record->id)

          var num = table.rows.length;
          var row = table.insertRow(num);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          cell1.innerHTML = "{{ $rec->inventory_name }}";
          cell2.innerHTML = "{{ $rec->quantity }}";

          @endif
        @endforeach
      @endif
      document.getElementById("delKits").action = "{{ url('/setKits/'.$record->id)}}";
      break;
    @endforeach
      default:
      document.getElementById('kits_name').value = "default";
      break;
  }
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          倉儲資訊 / Inventory
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          我的套件 / My Kits
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/setKits')}}"><button type="button" class="btn btn-primary btn-raised">返回 / back</button></a>
        </div>
        <div class="col-sm-12">
          <div class="col-sm-3">
            <div class="btn-group-vertical">
              @foreach($records as $record)
              <a class="btn btn-primary btn-raised" onclick="showKits('{{ $record->kits_name }}');">
                {{ $record->kits_name }}
              </a>
              @endforeach
            </div>
          </div>
          <div class="col-sm-9 form-group">
            <div class="col-sm-7">
              <table class="table table-bordered table-condensed table-hover">
                <tr>
                  <th class="success" colspan="2">套件ID</th>
                  <th class="success" colspan="2">套件名稱</th>
                  <th class="success" colspan="2">套件重量</th>
                </tr>
                <tr>
                  <td colspan="2" id="kits_id">
                    ID
                    <!--<input type="text" class="form-control" name="kits_id" id="kits_id" placeholder="Kits ID">-->
                  </td>
                  <td colspan="2" id="kits_name">
                    Name
                    <!--<input type="text" class="form-control" name="kits_name" id="kits_name" placeholder="Kits Name">-->
                  </td>
                  <td colspan="2" id="kits_weight">
                    Weight
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="kits_weight" id="kits_weight" placeholder="Kits Weight">-->
                  </td>
                </tr>
                <tr>
                  <th class="success" colspan="6">套件內容</th>
                </tr>
                <tr>
                  <td colspan="6" id="kits_description">
                    Descriptions
                    <!--<input type="text" class="form-control" name="kits_description" id="kits_description" placeholder="Kits Description">-->
                  </td>
                </tr>
                <tr class="success">
                  <th colspan="6">
                    價格區間
                  </th>
                </tr>
                <tr class="success">
                  <th>Price1</th><th>Price2</th><th>Price3</th><th>Price4</th><th>Price5</th><th>Price6</th>
                </tr>
                <tr>
                  <td id="price1">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price1" id="price1" placeholder="Price 1">-->
                  </td>
                  <td id="price2">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price2" id="price2" placeholder="Price 2">-->
                  </td>
                  <td id="price3">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price3" id="price3" placeholder="Price 3">-->
                  </td>
                  <td id="price4">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price4" id="price4" placeholder="Price 4">-->
                  </td>
                  <td id="price5">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price5" id="price5" placeholder="Price 5">-->
                  </td>
                  <td id="price6">
                    <!--<input type="number" step="0.01" min="0" class="form-control" name="price6" id="price6" placeholder="Price 6">-->
                  </td>
                </tr>
              </table>
              <div>
                <form class="form-horizontal" id="delKits" method="post" role="form">
                  {!! csrf_field() !!}
                  <input type="hidden" name="_method" value="delete" />
                  <input type="submit" class="btn btn-danger btn-raised" value="刪除 / Delete">
                </form>
              </div>
            </div>
            <div class="col-sm-5">
              <table class="table table-hover table-bordered table-condensed" id="selectedTable">
                <tr>
                  <th class="success col-sm-5">Item Name</th>
                  <th class="success col-sm-1">Quantity</th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
