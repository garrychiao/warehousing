
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
  cell5.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="total[]" value="0" required>';
  cell7.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="">';
  cell8.innerHTML = '<input type="button" class="btn btn-raised btn-sm btn-danger" onclick="delRow(this)" value="Delete">';
  resetTypeahead();
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
function changeConsignee(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("consignee").innerHTML = "{{ $lstCustomer->consignee_name }}\r\n{{ $lstCustomer->consignee_contact }}";
      document.getElementById("consignee").innerHTML +="\r\n{{ $lstCustomer->consignee_zip }} {{$lstCustomer->consignee_address}}";
      document.getElementById("consignee").innerHTML += "\r\n{{ $lstCustomer->consignee_phone }}";
    }
    changeNotifyParty(name);
    document.getElementById('Notify').selectedIndex=index;
  @empty
    document.getElementById("consignee").value = "";
  @endforelse
}
function changeNotifyParty(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("NotifyParty").innerHTML = "{{ $lstCustomer->notify_name }}\r\n{{ $lstCustomer->notify_contact }}";
      document.getElementById("NotifyParty").innerHTML +="\r\n{{ $lstCustomer->notify_zip }} {{$lstCustomer->notify_address}}";
      document.getElementById("NotifyParty").innerHTML += "\r\n{{ $lstCustomer->notify_phone }}";
    }
  @empty
    document.getElementById("Notify").value = "";
  @endforelse
}
function setUnitPrice(rowid){
  var row = rowid.parentNode.parentNode.cells;
  var item = row[0].children[0].value;
  var Qty = row[2].children[0].value;
  var UnitPrice = row[3].children[0].value;
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
  for (i=1;i<=length;i++) {
      FinalTotal += parseFloat(tblInventory.rows[i].cells[4].children[0].value, 2);
  }
  FinalTotal += parseFloat(document.getElementById('shipping').value,2)
  FinalTotal += parseFloat(document.getElementById('insurance').value,2)
  FinalTotal += parseFloat(document.getElementById('additional').value,2)
  document.getElementById("FinalTotal").value = FinalTotal.toFixed(2);
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          出貨單 / Commercial Invoice
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/shippment/commercial/create')}}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
        </div>
      </div>
      <!--info needed for purchase sheet-->
      <div class="col-sm-10 col-sm-offset-1">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form class="" action="{{ url('/shippment/commercial')}}" method="post" onkeydown="if(event.keyCode==13){return false;}">
          {!! csrf_field() !!}
          <div class="form-group">
            <table class="table table-condensed table-hover table-bordered">
              <tr class="success">
                <th colspan="2">ID</th>
                <th colspan="2">Create Date</th>
              </tr>
              <tr>
                <td colspan="2"><input id="form_id" type="text" class="form-control" name="order_id" required></td>
                <td colspan="2"><input id="date_now" type="date" class="form-control" name="create_date" required></td>
                <script type="text/javascript">
                  var now = new Date();
                  var time_now = ("0" + now.getYear()).slice(-2) + ("0" + now.getMonth(now.setMonth(now.getMonth()+1))).slice(-2) + ("0" + now.getDate()).slice(-2);
                  var date = new Date();
                  date.setHours(now.getDate() + 8 );
                  document.getElementById('form_id').value = "FA" + time_now + "-{{ $form_id }}";
                  document.getElementById('date_now').valueAsDate = date;
                </script>
              </tr>
              <tr class="success">
                <th class="col-sm-2">Date of Export</th>
                <th class="col-sm-2">Terms of sale</th>
                <th class="col-sm-2">Reference</th>
                <th class="col-sm-2">Currency</th>
              </tr>
              <tr>

                <td><input type="date" class="form-control" name="export_date" value=""></td>
                <td><input type="text" class="form-control" name="terms_of_sale" value=""></td>
                <td><input type="text" class="form-control" name="reference" value=""></td>
                <td><input type="text" class="form-control" name="currency" value=""></td>
              </tr>
              <tr class="success">
                <th colspan="2"> Shipper/Exporter :</th>
                <!--<td>
                  Took away 6/16 cuz this field is for Own Company, No need to choose
                  <select id="exporter" class="form-control" onchange="changeExporter(this)">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                    <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>-->
                <th>Consignee :</th>
                <td>
                  <select id="customer_id" name="customer_id" class="form-control" onchange="changeConsignee(this)">
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
                <td colspan="2">
                  <textarea type="text" rows="7" class="form-control" name="exporter" id="Exporter">{{ $mycompany->eng_name }}&#10;{{ $mycompany->eng_address }}&#10;{{ $mycompany->phone }}
                  </textarea>
                </td>
                <td colspan="2"><textarea type="text" rows="7" class="form-control" name="consignee" id="consignee"></textarea></td>
              </tr>
              <tr class="success">
                <th colspan="2">Country of Ultimate Destination</th>
                <th>Notify Party :</th>
                <td>
                  <select id="Notify" class="form-control" onchange="changeNotifyParty(this)">
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
                <td colspan="2"><input type="text" class="form-control" name="destination_country" value=""></td>
                <td colspan="2" rowspan="5"><textarea type="text" rows="9" class="form-control" name="notify_party" id="NotifyParty"></textarea></td>
              </tr>
              <tr class="success">
                <th colspan="2" class="col-sm-2">Country Of Manufacture</th>
              </tr>
              <tr>
                <td colspan="2"><input type="text" class="form-control" name="manufacture_country" value=""></td>
              </tr>
              <tr class="success">
                <th colspan="2" class="col-sm-2">International Airwaybill Number</th>
              </tr>
              <tr>
                <td colspan="2"><input type="text" class="form-control" name="airwaybill_number" value=""></td>
              </tr>
            </table>
            <table class="table table-condensed table-hover table-bordered" id="tblInventory">
              <tr class="success">
                <th class="col-sm-2">Item Id</th>
                <th class="col-sm-2">Item Name</th>
                <th class="col-sm-1">Quantity</th>
                <th class="col-sm-1">Unit Value</th>
                <th class="col-sm-2">Total Value</th>
                <!--
                <th class="col-sm-2">Full Description of Goods</th>
              -->
                <th class="col-sm-1">Weight (kg)</th>
                <th class="col-sm-1">操作</th>
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
                    <!--<option value="0">S&H</option>-->
                  </select>
                </td>
                <td>
                  <!--
                  <select name="item_name[]" class="form-control" onchange="changeByName(this)">
                    @if(count( $inventory_kits )>0)
                      @foreach( $inventory_kits as $kits)
                      Kits return value with heading "K"
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

                  @if(count($inventory)>0)
                  <input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_name}}@else{{$inventory->first()->item_name}}@endif">
                  @else
                  <input type="text" class="form-control typeahead" name="item_name[]" data-provide="typeahead" onchange="changeByName(this);">
                  @endif
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setUnitPrice(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="0" onchange="countTotal()" required>
                </td>
                <!--
                <td>
                  <input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">
                </td>
              -->
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="" required>
                </td>
                <td>
                  <input type="button" class="btn btn-info btn-sm btn-raised" onclick="addRow()" value="新增">
                </td>
              </tr>
            </table>
            <div class="col-sm-10">
              <table class="table table-condensed table-hover table-bordered">
                <tr class="success">
                  <th class="col-sm-2">Shipping Cost</th>
                  <th class="col-sm-2">Insurance Costs</th>
                  <th class="col-sm-2">Additional Costs</th>
                  <th class="col-sm-2">No. of Packages: </th>
                  <th class="col-sm-2">Total : $</th>
                </tr>
                <tr>
                  <td><input type="text" class="form-control" id="shipping" name="cost_shipping" onchange="countTotal()" value="0" required></td>
                  <td><input type="text" class="form-control" id="insurance" name="cost_insurance" onchange="countTotal()" value="0" required></td>
                  <td><input type="text" class="form-control" id="additional" name="cost_additional" onchange="countTotal()" value="0" required></td>
                  <td><input type="text" class="form-control" name="packages" value="1" required></td>
                  <td><input type="text" class="form-control" id="FinalTotal" name="final_total" value="0" readonly="true"></td>
                </tr>
              </table>
            </div>
            <div class="col-sm-2">
              <input type="submit" name="name" value="Submit" class="btn btn-success btn-lg btn-raised">
            </div>

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
