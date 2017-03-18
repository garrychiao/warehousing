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
  //var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(5);
  var cell8 = row.insertCell(6);
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
  //other cells
    @if(count($inventory)>0)
    cell2.innerHTML = '<input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);">';
    //cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">';
    @else
    cell2.innerHTML = '<input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);">';
    //cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="">';
    @endif
  cell3.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setUnitPrice(this)" required>';
  cell4.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>';
  cell5.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="total[]" value="0" onchange="countTotal()" required>';
  cell7.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="weight[]" onchange="countTotal()" value="0">';
  cell8.innerHTML = '<input type="button" class="btn btn-raised btn-sm btn-danger" onclick="delRow(this)" value="刪除 / Delete">';
  resetTypeahead();
}
function delRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}
//on inventory change, set item code and any thing else to columns
function changeInventory(name) {
  var value = name.value;
  var index = name.selectedIndex;
  var row = name.parentNode.parentNode.cells;
  row[1].children[0].selectedIndex = index;

  @if(count( $inventory_kits )>0)
    @foreach( $inventory_kits as $kits)
    if(value =="{{$kits->id}}K"){
      row[1].children[0].value = "{{ $kits->kits_name }}";
      //row[5].children[0].value = "{{ $kits->kits_description }}";
    }
    @endforeach
  @endif
  @forelse($inventory as $lstInventory)
    if(value =="{{$lstInventory->id}}"){
      row[1].children[0].value = "{{ $lstInventory->item_name }}";
      //row[5].children[0].value = "{{ $lstInventory->descriptions }}";
    }
  @empty
    row[1].children[0].text = " ";
  @endforelse
  setUnitPrice(name);
}
function changeByName(name){
  var value = name.value;
  var row = name.parentNode.parentNode.cells;
  var selItemId = row[0].children[0];
  switch(value) {
    @if(count( $inventory_kits )>0)
      @foreach( $inventory_kits as $kits)
      case "{{ $kits->kits_name}}":
        for (i = 0; i < selItemId.length; i++) {
          if(selItemId.options[i].value == "{{ $kits->id}}K"){
            row[0].children[0].selectedIndex = i;
           }
        }
        break;
      @endforeach
    @endif
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
    changeInventory(selItemId);
}
/*
function changeByName(name) {
  var index = name.selectedIndex;
  var row = name.parentNode.parentNode.cells;
  row[0].children[0].selectedIndex = index;
  var item_id = row[0].children[0];
  changeInventory(item_id);
}
*/
//on customer change, set customer info to the textarea
function changeBillCustomer(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("BillToInfo").innerHTML = "{{ $lstCustomer->eng_name }}\r\n{{ $lstCustomer->contact_person }}";
      document.getElementById("BillToInfo").innerHTML +="\r\n{{ $lstCustomer->notify_zip }} {{trim(preg_replace('/\s\s+/', ' ', $lstCustomer->notify_address))}}";
      document.getElementById("BillToInfo").innerHTML += "\r\n{{ $lstCustomer->phone }}";
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
      document.getElementById("ShipToInfo").innerHTML = "{{ $lstCustomer->eng_name }}\r\n{{ $lstCustomer->contact_person }}";
      document.getElementById("ShipToInfo").innerHTML +="\r\n{{ $lstCustomer->notify_zip }}{{trim(preg_replace('/\s\s+/', ' ', $lstCustomer->notify_address))}}";
      document.getElementById("ShipToInfo").innerHTML += "\r\n{{ $lstCustomer->phone }}";
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
        row[5].children[0].value = (Qty * {{ $kits->kits_weight }}).toFixed(2);
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
      row[5].children[0].value = (Qty * "{{ $lstInventory->unit_weight }}").toFixed(2);
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
  countTotal();
}
function countTotal(){
  var tblInventory = document.getElementById('tblInventory');
  var length = tblInventory.rows.length - 1;
  var i;
  var FinalTotal=0;
  var FinalWeight=0;
  for (i=1;i<=length;i++) {
      FinalTotal += parseFloat(tblInventory.rows[i].cells[4].children[0].value, 2);
      FinalWeight += parseFloat(tblInventory.rows[i].cells[5].children[0].value, 2);
  }
  FinalTotal += parseFloat(document.getElementById('sandh').value, 2);
  document.getElementById("FinalTotal").innerHTML = FinalTotal.toFixed(2);
  document.getElementById("FinalWeight").innerHTML = FinalWeight.toFixed(2);
}
function addQuotation(){
  document.getElementById('quotation').value="{{$quotation->quotation}}";
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
                <th class="success">編號 / ID</th><td><input id="form_id" type="text" class="form-control" name="order_id" required></td>
                <th class="success">日期 / Date</th><td><input type="date" id="date_now" class="form-control" name="create_date" value="" required></td>
              </tr>
              <tr>
                <th class="success">Bill To:</th>
                <td>
                  <select id="customer_id" name="customer_id" class="form-control" onchange="changeBillCustomer(this)" value="{{Request::old('customer_id')}}">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                    <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->eng_name }}}</option>
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>
                <th class="success">Ship To</th>
                <td>
                  <select id="shipTo" class="form-control" onchange="changeShipCustomer(this)">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                    <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->eng_name }}}</option>
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
                <th class="success col-sm-2">P.O Number</th>
                <th class="success col-sm-2">Payment Terms</th>
                <th class="success col-sm-2">Rep</th>
                <th class="success col-sm-2">Ship</th>
                <th class="success col-sm-2">Via</th>
                <th class="success col-sm-2">Shipping Term</th>
                <th class="success col-sm-2">Due Date</th>
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
                <th class="success col-sm-2">產品編號 / Item ID</th>
                <th class="success col-sm-3">產品名稱 / Item Name</th>
                <th class="success col-sm-2">訂單數量 / Quantity</th>
                <th class="success col-sm-2">單價 / Unit Price</th>
                <th class="success col-sm-2">金額 / Total</th>
                <!--<th class="success col-sm-2">內容</th>-->
                <th class="success col-sm-2">重量 / Weight</th>
                <th class="success col-sm-1"></th>
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
                  <input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);">
<!--
                  <select name="item_name[]" class="form-control select_search" onchange="changeByName(this)" style="width: 100%">
                    @if(count( $inventory_kits )>0)
                      @foreach( $inventory_kits as $kits)
                      <option value="{{ $kits->kits_name}}">{{{ $kits->kits_name }}}</option>
                      @endforeach
                    @endif
                    @forelse($inventory as $lstInventory)
                    <option value="{{ $lstInventory->item_name}}">{{{ $lstInventory->item_name }}}</option>
                    @empty
                    <option>Inventory empty!</option>
                    @endforelse
                  </select>
                -->
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
                  <input type="number" step="0.01" min="0" class="form-control" name="total[]" onchange="countTotal()" value="0" required>
                </td>
                <!--
                <td>
                  <input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">
                </td>
              -->
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="weight[]" onchange="countTotal()" value="0">
                </td>
                <td>
                  <input type="button" class="btn btn-info btn-sm btn-raised" onclick="addRow()" value="新增 / Add">
                </td>
              </tr>
            </table>
            <div class="col-sm-12">
              <table class="table">
                <tr>
                  <th class="success col-sm-3" colspan="2">
                    Quatation :
                    <button type="button" onclick="addQuotation();" class="btn btn-primary btn-sm btn-raised">ADD</button>
                  </th>
                  <td colspan="4">
                    <input type="text" class="form-control" name="quotation" id="quotation">
                  </td>
                </tr>
                <tr>
                  <th class="success col-sm-2">Shipping & Handling Cost</th>
                  <td class="col-sm-2"><input type="text" class="form-control" name="sandh" id="sandh" value="0" onchange="countTotal();"></td>
                  <th class="success col-sm-2">Total Weight: </th>
                  <td class="col-sm-2"><h4 id="FinalWeight"></h4></td>
                  <th class="success col-sm-2">Total : $</th>
                  <td class="col-sm-2"><h4 id="FinalTotal"></h4></td>
                </tr>
              </table>
            </div>
            <div class="col-sm-12">
              <input type="submit" name="name" value="Submit" class="btn btn-success btn-raised">
            </div>
            <script type="text/javascript">
              var now = new Date();
              var dd = now.getDate();
              var mm = now.getMonth()+1; //January is 0!
              var yyyy = ('0'+now.getFullYear()).slice(-2);
              if(dd<10) {
                  dd='0'+dd
              }
              if(mm<10) {
                  mm='0'+mm
              }
              //var time_now = ("0" + now.getYear()).slice(-2) + ("0" + now.getMonth(now.setMonth(now.getMonth()+1))).slice(-2) + ("0" + now.getDate()).slice(-2);
              document.getElementById('form_id').value = "FA" + yyyy+mm+dd + "-{{ $form_id }}";
              var date = new Date();
              var due_date = new Date();
              date.setHours(now.getDate() + 8 );
              due_date.setDate(now.getDate() + 7);
              due_date.setHours(due_date.getDate() + 8 );
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
<script src="{{asset('js/bootstrap3-typeahead.min.js')}}"></script>
<script>
  var data = [
    @if(count( $inventory_kits )>0)
      @foreach( $inventory_kits as $kits)
      "{{ $kits->kits_name }}",
      @endforeach
    @endif
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
