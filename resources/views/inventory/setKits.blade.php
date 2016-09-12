@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function addItem(){
    var unselected = document.getElementById("unselected");
    var selected = document.getElementById("selected");
    var table = document.getElementById("selectedTable");
    if(table.rows.length > 1){
      for(var y=table.rows.length ; y > 1 ; y--){
        table.deleteRow(y-1);
      }
    }
    for(var x=0 ; x<unselected.length ; x++){
      {
        if(unselected[x].selected)
        {
          var num = table.rows.length;
          var row = table.insertRow(num);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          cell1.innerHTML = '<input type="text" class="form-control" name="item_id[]" value="'+ unselected[x].value +'" readonly>';
          cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="'+ unselected[x].text +'" readonly>';
          cell3.innerHTML = '<input type="text" class="form-control" name="quantity[]" value="1" required>';

          //var option = document.createElement("option");
          //option.text = unselected[x].text;
          //option.value = unselected[x].value;
          //selected.appendChild(option);
        }
      }
    }
  }
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          倉儲資訊 / Inventory
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          設定套件 / Set Kits
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/inventory')}}"><button type="button" class="btn btn-primary btn-raised">返回 / back</button></a>
          <a href="{{ url('/setKits/create')}}"><button type="button" class="btn btn-primary btn-raised">我的套件 / My Kits</button></a>
        </div>
        <div class="col-sm-4">
          @if (count($lists) > 0)
            <select class="form-control" style='height:400px;border:solid 1px;' id="unselected" multiple>
              @foreach ($lists as $list)
              <option value="{{ $list->id }}">{{ $list->item_name}}</option>
              @endforeach
            </select>
          @endif
          <div class="col-sm-6">
            <button type="button" class="btn btn-info btn-raised" onclick="addItem()">Add</button>
          </div>
        </div>
        <form class="" action="{{ url('/setKits')}}" method="post" onkeydown="if(event.keyCode==13){return false;}">
          {!! csrf_field() !!}
          <div class="col-sm-8 form-group">
            <div class="col-sm-4">
              <table class="table table-bordered table-condensed table-hover">
                <tr>
                  <td>套件ID</td>
                  <td>套件名稱</td>
                </tr>
                <tr>
                  <td>
                    <input type="text" class="form-control" name="kits_id" placeholder="Kits ID">
                  </td>
                  <td>
                    <input type="text" class="form-control" name="kits_name" placeholder="Kits Name">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">套件重量</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="number" step="0.01" min="0" class="form-control" name="kits_weight" placeholder="Kits Weight">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">套件內容</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="text" class="form-control" name="kits_description" placeholder="Kits Description">
                  </td>
                </tr>
              </table>
              <input type="submit" name="name" value="Submit" class="btn btn-success btn-raised">
            </div>
            <!--<select name="items" class="form-control" style='height:300px;border:solid 1px;' id="selected" multiple>
            </select>-->
            <div class="col-sm-8">
              <table class="table table-hover table-bordered table-condensed">
                <tr>
                  <th colspan="6">
                    價格區間
                  </th>
                </tr>
                <tr>
                  <th>Price1</th><th>Price2</th><th>Price3</th><th>Price4</th><th>Price5</th><th>Price6</th>
                </tr>
                <tr>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price1" placeholder="Price 1">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price2" placeholder="Price 2">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price3" placeholder="Price 3">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price4" placeholder="Price 4">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price5" placeholder="Price 5">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="price6" placeholder="Price 6">
                  </td>
                </tr>
              </table>
              <table class="table table-hover table-bordered table-condensed" id="selectedTable">
                <tr>
                  <th class="col-sm-1">ID</th>
                  <th class="col-sm-5">Item Name</th>
                  <th class="col-sm-1">Quantity</th>
                </tr>
              </table>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
