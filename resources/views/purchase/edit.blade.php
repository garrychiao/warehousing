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
  selectList.setAttribute("onchange", "changeById(this)");
  cell1.appendChild(selectList);

    @forelse($select_inventory as $sel_inv)
      var option = document.createElement("option");
      option.value = "{{$sel_inv->id}}";
      option.text = "{{$sel_inv->item_id}}";
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
  cell3.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setTotal(this)" required>';
  cell4.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>';
  cell5.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="total[]" value="" required>';
  cell6.innerHTML = '<input type="text" class="form-control" name="remark[]" value="">';
  cell7.innerHTML = '<input type="button" class="btn btn-raised btn-danger btn-sm" onclick="delRow(this)" value="刪除 / Delete">';
  resetTypeahead();
}
function delRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}
function changeById(name) {
  var value = name.value;
  @forelse($select_inventory as $lstInventory)
    if(value =="{{$lstInventory->id}}"){
      var row = name.parentNode.parentNode.cells;
      row[1].children[0].value = "{{ $lstInventory->item_name }}";
    }
  @empty
    var row = name.parentNode.parentNode.cells;
    row[1].children[0].text = " ";
  @endforelse
}
function changeByName(name){
  var value = name.value;
  var row = name.parentNode.parentNode.cells;
  var selItemId = row[0].children[0];
  switch(value) {
    @forelse($inventory as $lstInventory)
    case "{{ $lstInventory->item_name}}":
      for (i = 0; i < selItemId.length; i++) {
        if(selItemId.options[i].value == "{{ $lstInventory->id}}"){
          row[0].children[0].selectedIndex = i;
         }
      }
      break;
    @empty

    @endforelse
      default:
    }
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
          <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/purchase/create') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
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
        <form action="{{ url('/purchase/'.$records->id)}}" method="post" onkeydown="if(event.keyCode==13){return false;}">
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="put" />
          <div class="form-group">
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <th class="success col-sm-2">訂單號碼 / ID</th><td class="col-sm-4"><input type="text" class="form-control" name="order_id" value="{{ $records->order_id }}"></td>
                <th class="success col-sm-2">交貨日期 / Delivery Date</th><td class="col-sm-4"><input type="date" class="form-control" name="delivery_date" value="{{ $records->delivery_date }}" required></td>
              </tr>
              <tr>
                <th class="success col-sm-2">供應廠商 / Supplier</th>
                <td class="col-sm-4">
                  <select id="supplier_id" name="supplier_id" class="form-control">
                    @forelse($supplier as $lstSupplier)
                      @if( $lstSupplier->id ==  $records->supplier_id){
                        <option selected="selected" value="{{ $lstSupplier->id }}">{{{ $lstSupplier->supplier_name }}}</option>
                      }
                      @else{
                        <option value="{{ $lstSupplier->id }}">{{{ $lstSupplier->supplier_name }}}</option>
                      }
                      @endif
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                </td>
                <th class="success col-sm-2">付款條件 / Payment Terms</th><td class="col-sm-4"><input type="text" class="form-control" name="payment_terms" value="{{ $records->payment_terms }}"></td>
              </tr>
              @if( count($mycompany)>0 )
              <tr>
                <th class="success col-sm-2">公司地址 / Company Address</th><td class="col-sm-4">{{ $mycompany->address }}</td>
                <th class="success col-sm-2">統一編號 / EIN</th><td class="col-sm-4">{{ $mycompany->EIN }}</td>
              </tr>
              <tr>
                <th class="success col-sm-2">聯絡人 / Contact Person</th><td class="col-sm-4">{{ $mycompany->contact_person }}</td>
                <th class="success col-sm-2">電話 / Phone</th><td class="col-sm-4">{{ $mycompany->phone }}</td>
              </tr>
              @endif
            </table>
            <table class="table table-condensed table-hover table-bordered" id="tblInventory">
              <tr>
                <th class="success col-sm-1">產品編號 / Item ID</th>
                <th class="success col-sm-2">產品名稱 / Item Name</th>
                <th class="success col-sm-1">訂單數量 / Quantity</th>
                <th class="success col-sm-1">單價 / Unit Price</th>
                <th class="success col-sm-1">金額 / Total</th>
                <th class="success col-sm-2">備註 / Remarks</th>
                <th class="success col-sm-1"></th>
              </tr>
              @foreach($inventory as $key => $inv)
              <tr>
                <td>
                  <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeById(this)">
                    @forelse($select_inventory as $lstInventory)
                      @if($lstInventory->id == $inv->inventory_id)
                        <option selected="selected" value="{{ $lstInventory->id}}">{{{ $lstInventory->item_id }}}</option>
                      @else
                        <option value="{{ $lstInventory->id}}">{{{ $lstInventory->item_id }}}</option>
                      @endif
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                </td>
                <td>
                  <input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);" value="{{$inv->item_name}}">
                  <!--<input type="text" class="form-control" name="item_name[]" value="{{$inv->item_name}}">-->
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="{{$inv->quantity}}" onchange="setTotal(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="{{$inv->unit_price}}" onchange="setTotal(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="{{$inv->total}}" required>
                </td>
                <td>
                  <input type="text" class="form-control" name="remark[]" value="{{$inv->remark}}">
                </td>
                <td>
                @if( $key == 0 )
                  <input type="button" class="btn btn-info btn-raised btn-sm" onclick="addRow()" value="新增 / Add">
                @else
                  <input type="button" class="btn btn-raised btn-danger btn-sm" onclick="delRow(this)" value="刪除 / Delete">
                @endif
                </td>
              </tr>
              @endforeach
            </table>
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <th class="success col-sm-2">送貨地點 / Delivery Address</th><td class="col-sm-4"><input type="text" class="form-control" name="delivery_address" value="{{ $records->delivery_address }}"></td>
                <th class="success col-sm-2">包裝方式 / Packing</th><td class="col-sm-4"><input type="text" class="form-control" name="packing" value="{{ $records->packing }}"></td>
              </tr>
              <tr>
                <th class="success col-sm-2">出貨樣 / Shipping Terms</th><td class="col-sm-4"><input type="text" class="form-control" name="shipping_sample" value="{{ $records->shipping_sample }}"></td>
                <th class="success col-sm-2">注意事項 / Precautions</th><td class="col-sm-4"><input type="text" class="form-control" name="precautions" value="{{ $records->precautions }}"></td>
              </tr>
              <tr>
                <th class="success col-sm-2">採購日期 / Purchase Date</th><td class="col-sm-4"><input type="date" class="form-control" name="purchase_date" value="{{ $records->purchase_date }}" required></td>
                <th class="success col-sm-2">承辦人 / Undertaker</th><td class="col-sm-4"><input type="text" class="form-control" name="undertaker" value="{{ $records->undertaker }}"></td>
              </tr>
            </table>
          </div>
          <input type="submit" name="name" value="Submit" class="btn btn-success btn-raised">
        </form>
      </div>
    </div>
</div>
<script src="{{asset('js/bootstrap3-typeahead.min.js')}}"></script>
<script>
  var data = [
    @forelse($inventory as $lstInventory)
      "{{ $lstInventory->item_name }}",
    @empty

    @endforelse
  ];
  function resetTypeahead(){
    $('.typeahead').typeahead('destroy');
    $('.typeahead').typeahead({source:data,
      autoSelect: true});
  }
  $('.typeahead').typeahead({source:data,
    autoSelect: true});
</script>

@endsection
