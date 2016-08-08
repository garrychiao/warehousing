@extends('layouts.app')

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
  var cell8 = row.insertCell(7);
  //Create and append select list
  //cell1
  var selectList = document.createElement("select");
  selectList.id = "Select_id";
  selectList.name = "item_id[]";
  selectList.className = "form-control";
  selectList.setAttribute("onchange", "changeInventory(this)");
  cell1.appendChild(selectList);
  @if(count( $inventory_kits )>0)
    @foreach( $inventory_kits as $kits)
    var option = document.createElement("option");
    option.value = "{{$kits->id}}K";
    option.text = "{{$kits->kits_id}}";
    selectList.appendChild(option);
    @endforeach
  @endif
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
  //cell2
  var selectList_cell2 = document.createElement("select");
  selectList_cell2.name = "item_name[]";
  selectList_cell2.className = "form-control";
  selectList_cell2.setAttribute("onchange", "changeByName(this)");
  cell2.appendChild(selectList_cell2);
  @if(count( $inventory_kits )>0)
    @foreach( $inventory_kits as $kits)
    var option = document.createElement("option");
    option.value = "{{$kits->kits_name}}";
    option.text = "{{$kits->kits_name}}";
    selectList_cell2.appendChild(option);
    @endforeach
  @endif
  @forelse($inventory as $lstInventory)
    var option = document.createElement("option");
    option.value = "{{$lstInventory->item_name}}";
    option.text = "{{$lstInventory->item_name}}";
    selectList_cell2.appendChild(option);
  @empty
    var option = document.createElement("option");
    option.text = "No Inventory";
    selectList_cell2.appendChild(option);
  @endforelse
  //other cells
    @if(count($inventory)>0)
    //cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_name}}@else{{$inventory->first()->item_name}}@endif" required>';
    cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">';
    @else
    //cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="" required>';
    cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="">';
    @endif
  cell3.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setUnitPrice(this)" required>';
  cell4.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>';
  cell5.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="total[]" value="0" required>';
  cell7.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="">';
  cell8.innerHTML = '<input type="button" class="btn btn-raised btn-sm btn-danger" onclick="delRow(this)" value="Delete">';
}
function delRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}
//on inventory change, set item code and any thing else to columns
function changeInventory(name) {
  var value = name.value;
  var row = name.parentNode.parentNode.cells;
  @if(count( $inventory_kits )>0)
    @foreach( $inventory_kits as $kits)
    if(value =="{{$kits->id}}K"){
      row[1].children[0].value = "{{ $kits->kits_name }}";
      row[5].children[0].value = "{{ $kits->kits_description }}";
    }
    @endforeach
  @endif
  @forelse($inventory as $lstInventory)
    if(value =="{{$lstInventory->id}}"){
      row[1].children[0].value = "{{ $lstInventory->item_name }}";
      row[5].children[0].value = "{{ $lstInventory->descriptions }}";
    }
  @empty
    row[1].children[0].text = " ";
  @endforelse
  setUnitPrice(name);
}
function changeByName(name) {
  var index = name.selectedIndex;
  var row = name.parentNode.parentNode.cells;
  row[0].children[0].selectedIndex = index;
  var item_id = row[0].children[0];
  changeInventory(item_id);
}
//on customer change, set customer info to the textarea
function changeBillCustomer(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("BillToInfo").innerHTML = "{{ $lstCustomer->chi_name }}\r\n{{ $lstCustomer->contact_person }}";
      document.getElementById("BillToInfo").innerHTML += "\r\n{{ $lstCustomer->phone }}";
      document.getElementById("BillToInfo").innerHTML +="\r\n{{ $lstCustomer->notify_zip }} {{$lstCustomer->notify_address}}";
      changeShipCustomer(name);
      document.getElementById('shipTo').selectedIndex=index;
    }
  @empty
    document.getElementById("BillToInfo").value = "";
  @endforelse
}
function changeShipCustomer(name) {
  var value = name.value;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("ShipToInfo").innerHTML = "{{ $lstCustomer->chi_name }}\r\n{{ $lstCustomer->contact_person }}";
      document.getElementById("ShipToInfo").innerHTML += "\r\n{{ $lstCustomer->phone }}";
      document.getElementById("ShipToInfo").innerHTML +="\r\n{{ $lstCustomer->notify_zip }}{{$lstCustomer->notify_address}}";
    }
  @empty
    document.getElementById("ShipToInfo").value = "";
  @endforelse
}
function setUnitPrice(rowid){
  var row = rowid.parentNode.parentNode.cells;
  var item = row[0].children[0].value;
  var Qty = row[2].children[0].value;
  var UnitPrice = row[3].children[0].value;
  //Qty * Unit Price
  if(isNaN(Qty)){
    return ;
  }else{
    @if(count( $inventory_kits )>0)
      @foreach( $inventory_kits as $kits)
      if(item =="{{$kits->id}}K"){
        if(Qty <=20){
          row[3].children[0].value = "{{ $kits->price1 }}";
        }
        if(Qty >20 && Qty <= 100){
          row[3].children[0].value = "{{ $kits->price2 }}";
        }
        if(Qty >100 && Qty <= 300){
          row[3].children[0].value = "{{ $kits->price3 }}";
        }
        if(Qty >300 && Qty <= 500){
          row[3].children[0].value = "{{ $kits->price4 }}";
        }
        if(Qty >500 && Qty <= 1000){
          row[3].children[0].value = "{{ $kits->price5 }}";
        }
        if(Qty >1000){
          row[3].children[0].value = "{{ $kits->price6 }}";
        }
        //set total weight
        row[6].children[0].value = (Qty * {{ $kits->kits_weight }}).toFixed(2);
      }
      @endforeach
    @endif
    @forelse($inventory as $lstInventory)
    if(item =="{{$lstInventory->id}}"){
      if(Qty <=20){
        row[3].children[0].value = "{{ $lstInventory->price1 }}";
      }
      if(Qty >20 && Qty <= 100){
        row[3].children[0].value = "{{ $lstInventory->price2 }}";
      }
      if(Qty >100 && Qty <= 300){
        row[3].children[0].value = "{{ $lstInventory->price3 }}";
      }
      if(Qty >300 && Qty <= 500){
        row[3].children[0].value = "{{ $lstInventory->price4 }}";
      }
      if(Qty >500 && Qty <= 1000){
        row[3].children[0].value = "{{ $lstInventory->price5 }}";
      }
      if(Qty >1000){
        row[3].children[0].value = "{{ $lstInventory->price6 }}";
      }
      //set total weight
      row[6].children[0].value = (Qty * "{{ $lstInventory->unit_weight }}").toFixed(2);
    }
    @empty
      row[3].children[0].value = "";
    @endforelse
    setTotal(rowid);
  }
}
function setTotal(rowid){
  var row = rowid.parentNode.parentNode.cells;
  var Qty = row[2].children[0].value;
  var UnitPrice = row[3].children[0].value;
  if(isNaN(Qty)||isNaN(UnitPrice)){
    return ;
  }else{
    row[4].children[0].value = (Qty*UnitPrice).toFixed(2);
  }
  var tblInventory = document.getElementById('tblInventory');
  var length = tblInventory.rows.length - 1;
  var i;
  var FinalTotal=0;
  for (i=1;i<=length;i++) {
      FinalTotal += parseFloat(tblInventory.rows[i].cells[4].children[0].value, 2);
  }
  document.getElementById("FinalTotal").innerHTML = FinalTotal.toFixed(2);
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          報價單 / Proforma Invoice
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/shippment/proforma/create') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
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
        <form class="" action="{{ url('/shippment/proforma')}}" method="post" onkeydown="if(event.keyCode==13){return false;}">
          {!! csrf_field() !!}
          <div class="form-group">
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td>編號</td><td><input id="form_id" type="text" class="form-control" name="order_id" required></td>
                <td>日期</td><td><input type="date" id="date_now" class="form-control" name="create_date" value="" required></td>

              </tr>
              <tr>
                <td>Bill To:</td>
                <td>
                  <select id="customer_id" name="customer_id" class="form-control" onchange="changeBillCustomer(this)" value="{{Request::old('customer_id')}}">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                    <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>
                <td>Ship To</td>
                <td>
                  <select id="shipTo" class="form-control" onchange="changeShipCustomer(this)">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                    <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2"><textarea type="text" rows="5" class="form-control" name="bill_to" id="BillToInfo" required>{{Request::old('bill_to')}}</textarea></td>
                <td colspan="2"><textarea type="text" rows="5" class="form-control" name="ship_to" id="ShipToInfo" required>{{Request::old('ship_to')}}</textarea></td>
              </tr>
            </table>
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td class="col-sm-2">P.O Number</td>
                <td class="col-sm-2">Payment Terms</td>
                <td class="col-sm-2">Rep</td>
                <td class="col-sm-2">Ship</td>
                <td class="col-sm-2">Via</td>
                <td class="col-sm-2">Shipping Term</td>
                <td class="col-sm-2">Due Date</td>
              </tr>
              <tr>
                <td><input type="text" class="form-control" name="POnumber" value="{{Request::old('POnumber')}}"></td>
                <td><input type="text" class="form-control" name="payment_terms" value="{{Request::old('payment_terms')}}"></td>
                <td><input type="text" class="form-control" name="rep" value="{{Request::old('rep')}}"></td>
                <td><input type="date" class="form-control" name="ship" value="{{Request::old('ship')}}"></td>
                <td><input type="text" class="form-control" name="via" value="{{Request::old('via')}}"></td>
                <td><input type="text" class="form-control" name="FOB" value="{{Request::old('FOB')}}"></td>
                <td><input type="date" class="form-control" id="due_date" name="due_date" value="{{Request::old('due_date')}}"></td>
              </tr>

            </table>
            <table class="table table-condensed table-hover table-bordered" id="tblInventory">
              <tr>
                <td class="col-sm-2">產品編號</td>
                <td class="col-sm-2">產品名稱</td>
                <td class="col-sm-1">訂單數量</td>
                <td class="col-sm-1">單價</td>
                <td class="col-sm-1">金額</td>
                <td class="col-sm-2">內容</td>
                <td class="col-sm-1">重量</td>
                <td class="col-sm-1">操作</td>
              </tr>
              <tr>
                <td>
                  <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeInventory(this)">
                    @if(count( $inventory_kits )>0)
                      @foreach( $inventory_kits as $kits)
                      <!--Kits return value with heading "K"-->
                      <option value="{{ $kits->id}}K">{{{ $kits->kits_id }}}</option>
                      @endforeach
                    @endif
                    @forelse($inventory as $lstInventory)
                    <option value="{{ $lstInventory->id}}">{{{ $lstInventory->item_id }}}</option>
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                </td>
                <td>
                  <select id="select_item_id" name="item_name[]" class="form-control" onchange="changeByName(this)">
                    @if(count( $inventory_kits )>0)
                      @foreach( $inventory_kits as $kits)
                      <!--Kits return value with heading "K"-->
                      <option value="{{ $kits->kits_name}}">{{{ $kits->kits_name }}}</option>
                      @endforeach
                    @endif
                    @forelse($inventory as $lstInventory)
                    <option value="{{ $lstInventory->item_name}}">{{{ $lstInventory->item_name }}}</option>
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                  <!--
                  @if(count($inventory)>0)
                  <input type="text" class="form-control" name="item_name[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_name}}@else{{$inventory->first()->item_name}}@endif">
                  @else
                  <input type="text" class="form-control" name="item_name[]" value="" required>
                  @endif
                -->
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setUnitPrice(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="" required>
                </td>
                <td>
                  <input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="">
                </td>
                <td>
                  <input type="button" class="btn btn-info btn-sm btn-raised" onclick="addRow()" value="新增">
                </td>
              </tr>
            </table>
            <div class="col-sm-12">
              <table class="table">
                <tr>
                  <th class="col-sm-3">Shipping & Handling Cost</th>
                  <th class="col-sm-3"><input type="text" class="form-control" name="sandh" value="0"></th>
                  <th class="col-sm-3">Total : $</th>
                  <th class="col-sm-3"><h4 id="FinalTotal"></h4></th>
                </tr>
              </table>
            </div>
            <div class="col-sm-12">
              <input type="submit" name="name" value="Submit" class="btn btn-success btn-raised">
            </div>
            <script type="text/javascript">
              var now = new Date();
              var time_now = ("0" + now.getYear()).slice(-2) + ("0" + now.getMonth(now.setMonth(now.getMonth()+1))).slice(-2) + ("0" + now.getDate()).slice(-2);
              var date = new Date();
              var due_date = new Date();
              date.setHours(now.getDate() + 8 );
              due_date.setDate(now.getDate() + 7);
              due_date.setHours(due_date.getDate() + 8 );
              document.getElementById('form_id').value = "FA" + time_now + "-{{ $form_id }}";
              document.getElementById('date_now').valueAsDate = date;
              document.getElementById('due_date').valueAsDate = due_date;
            </script>
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
