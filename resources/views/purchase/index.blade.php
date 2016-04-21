@extends('layouts.app')<!--this is purchase index-->

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
function addRow() {
  var table = document.getElementById("tblInventory");
  var num = document.getElementById("tblInventory").rows.length;
  var row = table.insertRow(num);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(6);
  //Create and append select list
  var selectList = document.createElement("select");
  selectList.id = "Select_id";
  selectList.name = "item_id[]";
  selectList.className = "form-control";
  selectList.setAttribute("onchange", "changeName(this)");
  cell1.appendChild(selectList);

    @forelse($inventory as $lstInventory)
      var option = document.createElement("option");
      option.value = "{{$lstInventory->id}}";
      option.text = "{{$lstInventory->item_id}}";
      selectList.appendChild(option);
    @empty
      var option = document.createElement("option");
      option.text = "No Inventory";
      selectList.appendChild(option);
      cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="">';
    @endforelse

    @if(count($inventory)>0)
    cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="{{$inventory->first()->item_name}}">';
    @else
    cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="">';
    @endif
  cell3.innerHTML = '<input type="text" class="form-control" name="quantity[]" value="" onchange="setTotal(this)">';
  cell4.innerHTML = '<input type="text" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)">';
  cell5.innerHTML = '<input type="text" class="form-control" name="total[]" value="">';
  cell6.innerHTML = '<input type="text" class="form-control" name="remark[]" value="">';
  cell7.innerHTML = '<input type="button" class="btn btn-raised btn-danger" onclick="delRow(this)" value="Delete">';
}
function delRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}
function changeName(name) {
  var value = name.value;
  @forelse($inventory as $lstInventory)
    if(value =="{{$lstInventory->id}}"){
      var row = name.parentNode.parentNode.cells;
      row[1].children[0].value = "{{ $lstInventory->item_name }}";
    }
  @empty
    var row = name.parentNode.parentNode.cells;
    row[1].children[0].text = " ";
  @endforelse
}
function setTotal(rowid){
  var row = rowid.parentNode.parentNode.cells;
  var Qty = row[2].children[0].value;
  var UnitPrice = row[3].children[0].value;
  if(isNaN(Qty)||isNaN(UnitPrice)){
    return ;
  }else{
    row[4].children[0].value = Qty*UnitPrice;
  }
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          採購單 / Purchasing
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/purchase/create"><button type="button" class="btn btn-primary btn-raised">採購紀錄 / Records</button></a>
        </div>
      </div>
      <!--info needed for purchase sheet-->
      <div class="col-sm-offset-1 col-sm-10">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form class="" action="{{ url('/purchase')}}" method="post">
          {!! csrf_field() !!}
          <div class="form-group">
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td>訂單號碼</td><td><input type="text" class="form-control" name="order_id"></td>
                <td>交貨日期</td><td><input type="date" class="form-control" name="delivery_date"></td>
              </tr>
              <tr>
                <td>供應廠商</td>
                <td>
                  <select id="supplier_id" name="supplier_id" class="form-control">
                    @forelse($supplier as $lstSupplier)
                    <option value="{{ $lstSupplier->id }}">{{{ $lstSupplier->supplier_name }}}</option>
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                </td>
                <td>付款條件</td><td><input type="text" class="form-control" name="payment_terms"></td>
              </tr>
              @if( count($mycompany)>0 )
              <tr>
                <td>公司地址</td><td>{{ $mycompany->address }}</td>
                <td>統一編號</td><td>{{ $mycompany->EIN }}</td>
              </tr>
              <tr>
                <td>聯絡人</td><td>{{ $mycompany->contact_person }}</td>
                <td>電話</td><td>{{ $mycompany->phone }}</td>
              </tr>
              @endif
            </table>
            <table class="table table-condensed table-hover table-bordered" id="tblInventory">
              <tr>
                <td class="col-sm-2">產品編號</td>
                <td class="col-sm-2">產品名稱</td>
                <td class="col-sm-2">訂單數量</td>
                <td class="col-sm-2">單價</td>
                <td class="col-sm-2">金額</td>
                <td class="col-sm-2">備註</td>
                <td class="col-sm-2">操作</td>
              </tr>
              <tr>
                <td>
                  <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeName(this)">
                    @forelse($inventory as $lstInventory)
                    <option value="{{ $lstInventory->id}}">{{{ $lstInventory->item_id }}}</option>
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                </td>
                <td>
                  @if(count($inventory)>0)
                  <input type="text" class="form-control" name="item_name[]" value="{{$inventory->first()->item_name}}">
                  @else
                  <input type="text" class="form-control" name="item_name[]" value="">
                  @endif
                </td>
                <td>
                  <input type="text" class="form-control" name="quantity[]" value="" onchange="setTotal(this)">
                </td>
                <td>
                  <input type="text" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)">
                </td>
                <td>
                  <input type="text" class="form-control" name="total[]" value="">
                </td>
                <td>
                  <input type="text" class="form-control" name="remark[]" value="">
                </td>
                <td>
                  <input type="button" class="btn btn-info btn-raised" onclick="addRow()" value="新增">
                </td>
              </tr>
            </table>
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td>送貨地點</td><td><input type="text" class="form-control" name="delivery_address"></td>
                <td>包裝方式</td><td><input type="text" class="form-control" name="packing"></td>
              </tr>
              <tr>
                <td>出貨樣</td><td><input type="text" class="form-control" name="shipping_sample"></td>
                <td>注意事項</td><td><input type="text" class="form-control" name="precautions"></td>
              </tr>
              <tr>
                <td>採購日期</td><td><input type="date" class="form-control" name="purchase_date"></td>
                <td>承辦人</td><td><input type="text" class="form-control" name="undertaker"></td>
              </tr>
            </table>
          </div>
          <input type="submit" name="name" value="Submit" class="btn btn-success btn-raised">

<!--
          <div class="form-group">
            <label class="col-sm-2 control-label">產品編號</label>
            <label class="col-sm-2 control-label">產品名稱</label>
            <label class="col-sm-2 control-label">訂單數量</label>
            <label class="col-sm-2 control-label">單價</label>
            <label class="col-sm-2 control-label">金額</label>
            <label class="col-sm-2 control-label">操作</label>
            <div class="col-sm-2" id="div_item_id">
              <input type="text" class="form-control" name="item_id[]" value="">
            </div>
            <div class="col-sm-2" id="div_item_name">
              <input type="text" class="form-control" name="item_name[]" value="">
            </div>
            <div class="col-sm-2" id="div_quantity">
              <input type="text" class="form-control" name="quantity[]" value="">
            </div>
            <div class="col-sm-2" id="div_unit_price">
              <input type="text" class="form-control" name="unit_price[]" value="">
            </div>
            <div class="col-sm-2" id="div_total">
              <input type="text" class="form-control" name="total[]" value="">
            </div>
            <div class="col-sm-2" id="div_remark">
              <input type="button" class="btn btn-danger btn-raised" disabled="true" value="Del">
            </div>
            <div class="col-sm-2">
              <input type="button" name="btnAddInput" id="btnAddInput" class="btn btn-raised btn-lg" value="+">
              <input type="button" name="btnDelInput" id="btnDelInput" class="btn btn-raised btn-lg" value="-">
            </div>
          </div>-->
        </form>
      </div>
    </div>
</div>

@endsection
