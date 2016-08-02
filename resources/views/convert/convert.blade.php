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
    @if(count($inventory)>0)
    cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_name}}@else{{$inventory->first()->item_name}}@endif" required>';
    cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="@if(count($inventory_kits)>0){{$inventory_kits->first()->kits_description}}@else{{$inventory->first()->description}}@endif">';
    @else
    cell2.innerHTML = '<input type="text" class="form-control" name="item_name[]" value="" required>';
    cell6.innerHTML = '<input type="text" class="form-control" name="description[]" value="">';
    @endif
  cell3.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="" onchange="setUnitPrice(this)" required>';
  cell4.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="" onchange="setTotal(this)" required>';
  cell5.innerHTML = '<input type="number" step="0.01" min="0" class="form-control" name="total[]" value="0" onchange="countTotal()" required>';
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
  if(value =="0"){
    row[1].children[0].value = "S&H";
    row[2].children[0].value = "0";
    row[3].children[0].value = "0";
    row[4].children[0].value = "0";
    row[5].children[0].value = "Shipping and Handling Charge";
  }
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
/*
function changeExporter(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("Exporter").innerHTML = "{{ $lstCustomer->chi_name }}\r\n{{ $lstCustomer->contact_person }}";
      document.getElementById("Exporter").innerHTML += "\r\n{{ $lstCustomer->phone }}";
      document.getElementById("Exporter").innerHTML +="\r\n{{ $lstCustomer->recieve_zip_code }} {{$lstCustomer->recieve_address}}";
      changeShipCustomer(name);
    }
  @empty
    document.getElementById("exporter").value = "";
  @endforelse
}*/
function changeConsignee(name) {
  var value = name.value;
  var index = name.selectedIndex;
  @forelse($customer as $lstCustomer)
    if(value =="{{$lstCustomer->id}}"){
      document.getElementById("consignee").innerHTML = "{{ $lstCustomer->consignee_name }}\r\n{{ $lstCustomer->consignee_contact }}";
      document.getElementById("consignee").innerHTML += "\r\n{{ $lstCustomer->consignee_phone }}";
      document.getElementById("consignee").innerHTML +="\r\n{{ $lstCustomer->consignee_zip }} {{$lstCustomer->consignee_address }}";
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
      document.getElementById("NotifyParty").innerHTML += "\r\n{{ $lstCustomer->notify_phone }}";
      document.getElementById("NotifyParty").innerHTML +="\r\n{{ $lstCustomer->notify_zip }} {{$lstCustomer->notify_address}}";
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
          轉換報價單 / Convert to Commercial Invoice
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/shippment/commercial/create"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
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
                <td colspan="2"><input id="form_id" type="text" class="form-control" name="order_id" value="{{ $records->order_id }}" required></td>
                <td colspan="2"><input id="create_date" type="date" class="form-control" name="create_date" value="{{ $records->create_date }}" required></td>
              </tr>
              <tr class="success">
                <th class="col-sm-2">Date of Export</th>
                <th class="col-sm-2">Terms of sale</th>
                <th class="col-sm-2">Reference</th>
                <th class="col-sm-2">Currency</th>
              </tr>
              <tr>
                <td><input type="date" class="form-control" name="export_date" value="{{ $records->export_date}}"></td>
                <td><input type="text" class="form-control" name="terms_of_sale" value="{{ $records->payment_terms }}"></td>
                <td><input type="text" class="form-control" name="reference" value="{{ $records->order_id }}" ></td>
                <td><input type="text" class="form-control" name="currency" value="{{ $rec_customer->currency }}" ></td>
              </tr>
              <tr class="success">
                <th colspan="2"> Shipper/Exporter :</th>
                <th>Consignee : </th>
                <td>
                  <select id="customer_id" name="customer_id" class="form-control" onchange="changeConsignee(this)">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                      @if($lstCustomer->id == $records->customer_id)
                        <option selected="selected" value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                      @else
                        <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                      @endif
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea type="text" rows="7" class="form-control" name="exporter" id="Exporter">{{ $mycompany->eng_name }}&#10;{{ $mycompany->contact_person }}&#10;{{ $mycompany->phone }}&#10;{{ $mycompany->eng_address }}
                  </textarea>
                </td>
                <td colspan="2">
                  <textarea type="text" rows="7" class="form-control" name="consignee" id="consignee">{{ $rec_customer->consignee_name }}&#10;{{ $rec_customer->consignee_contact }}&#10;{{ $rec_customer->consignee_phone }}&#10;{{ $rec_customer->consignee_zip }} {{ $rec_customer->consignee_address }}
                  </textarea>
                </td>
              </tr>
              <tr class="success">
                <th colspan="2">Country of Ultimate Destination</th>
                <th>Notify Party :</th>
                <td>
                  <select id="Notify" class="form-control" onchange="changeNotifyParty(this)">
                    <option>--Setect--</option>
                    @forelse($customer as $lstCustomer)
                      @if($lstCustomer->id == $records->customer_id)
                        <option selected="selected" value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                      @else
                        <option value="{{ $lstCustomer->id }}">{{{ $lstCustomer->contact_person }}}</option>
                      @endif
                    @empty
                    <option>No Customer!</option>
                    @endforelse
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2"><input type="text" class="form-control" name="destination_country" value="{{ $rec_customer->nationality}}"></td>
                <td colspan="2" rowspan="5">
                  <textarea type="text" rows="9" class="form-control" name="notify_party" id="NotifyParty">{{ $rec_customer->notify_name }}&#10;{{ $rec_customer->notify_contact }}&#10;{{ $rec_customer->notify_phone }}&#10;{{ $rec_customer->notify_zip }} {{ $rec_customer->notify_address }}
                  </textarea>
                </td>
              </tr>
              <tr class="success">
                <th colspan="2" class="col-sm-2">Country Of Manufacture</th>
              </tr>
              <tr>
                <td colspan="2"><input type="text" class="form-control" name="manufacture_country" value="Taiwan (ROC)"></td>
              </tr>
              <tr class="success">
                <th colspan="2" class="col-sm-2">International Airwaybill Number</th>
              </tr>
              <tr>
                <td colspan="2"><input type="text" class="form-control" name="airwaybill_number" value="{{ $records->airwaybill_number}}"></td>
              </tr>
            </table>

            <table class="table table-condensed table-hover table-bordered" id="tblInventory">
              <tr class="success">
                <th class="col-sm-2">Item Id</th>
                <th class="col-sm-2">Item Name</th>
                <th class="col-sm-1">Quantity</th>
                <th class="col-sm-1">Unit Value</th>
                <th class="col-sm-2">Total Value</th>
                <th class="col-sm-2">Full Description of Goods</th>
                <th class="col-sm-1">Weight (kg)</th>
                <th class="col-sm-1">操作</th>
              </tr>
              @if(count($inventory_kits_records)>0)
              <!--kits will be displayed first, then signle invs-->
                @foreach($inventory_kits_records as $key => $kit)
                <tr>
                  <td>
                    <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeInventory(this)">
                      @if(count( $inventory_kits )>0)
                        @foreach( $inventory_kits as $kits)
                          @if($kits->id == $kit->kits_id)
                            <option selected="selected" value="{{ $kits->id}}K">{{{ $kits->kits_id }}}</option>
                          @else
                            <option value="{{ $kits->id}}K">{{{ $kits->kits_id }}}</option>
                          @endif
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
                    <input type="text" class="form-control" name="item_name[]" value="{{$kit->kits_name}}">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="{{$kit->quantity}}" onchange="setUnitPrice(this)" required>
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="{{$kit->unit_price}}" onchange="setTotal(this)" required>
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="{{$kit->total}}" required>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="description[]" value="{{$kit->description}}">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="{{$kit->weight}}">
                  </td>
                  <td>
                    @if( $key == 0 )
                      <input type="button" class="btn btn-info btn-raised" onclick="addRow()" value="新增">
                    @else
                      <input type="button" class="btn btn-raised btn-danger" onclick="delRow(this)" value="Delete">
                    @endif
                  </td>
                </tr>
                @endforeach
                <!--single inv parts-->
                @foreach($rec_inventory as $key => $inv)
                <tr>
                  <td>
                    <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeInventory(this)">
                      @if(count( $inventory_kits )>0)
                        @foreach( $inventory_kits as $kits)
                        <!--Kits return value with final "K"-->
                        <option value="{{ $kits->id}}K">{{{ $kits->kits_id }}}</option>
                        @endforeach
                      @endif
                      @forelse($inventory as $lstInventory)
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
                    <input type="text" class="form-control" name="item_name[]" value="{{$inv->item_name}}">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="{{$inv->quantity}}" onchange="setUnitPrice(this)" required>
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="{{$inv->unit_price}}" onchange="setTotal(this)" required>
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="{{$inv->total}}" required>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="description[]" value="{{$inv->description}}">
                  </td>
                  <td>
                    <input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="{{$inv->weight}}">
                  </td>
                  <td>
                    <input type="button" class="btn btn-raised btn-danger" onclick="delRow(this)" value="Delete">
                  </td>
                </tr>
                @endforeach
              @else
              @foreach($rec_inventory as $key => $inv)
              <tr>
                <td>
                  <select id="select_item_id" name="item_id[]" class="form-control" onchange="changeInventory(this)">
                    @if(count( $inventory_kits )>0)
                      @foreach( $inventory_kits as $kits)
                      <!--Kits return value with final "K"-->
                      <option value="{{ $kits->id}}K">{{{ $kits->kits_id }}}</option>
                      @endforeach
                    @endif
                    @forelse($inventory as $lstInventory)
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
                  <input type="text" class="form-control" name="item_name[]" value="{{$inv->item_name}}">
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="quantity[]" value="{{$inv->quantity}}" onchange="setUnitPrice(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="unit_price[]" value="{{$inv->unit_price}}" onchange="setTotal(this)" required>
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="total[]" value="{{$inv->total}}" required>
                </td>
                <td>
                  <input type="text" class="form-control" name="description[]" value="{{$inv->description}}">
                </td>
                <td>
                  <input type="number" step="0.01" min="0" class="form-control" name="weight[]" value="{{$inv->weight}}">
                </td>
                <td>
                  @if( $key == 0 )
                    <input type="button" class="btn btn-info btn-raised" onclick="addRow()" value="新增">
                  @else
                    <input type="button" class="btn btn-raised btn-danger" onclick="delRow(this)" value="Delete">
                  @endif
                </td>
              </tr>
              @endforeach
              @endif
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
                  <td><input type="text" class="form-control" id="shipping" name="cost_shipping" onchange="countTotal()" value="{{$records->sandh}}"></td>
                  <td><input type="text" class="form-control" id="insurance" name="cost_insurance" onchange="countTotal()" value="0"></td>
                  <td><input type="text" class="form-control" id="additional" name="cost_additional" onchange="countTotal()" value="0"></td>
                  <td><input type="text" class="form-control" name="packages" value="1"></td>
                  <td><input type="text" class="form-control" id="FinalTotal" name="final_total" value="{{$final_total}}" readonly="true"></td>
                </tr>
              </table>
            </div>
            <input name="proforma_id" type="hidden" value="{{ $proforma_id }}">
            <!--<input name="converted" type="hidden" value="true">-->
            <div class="col-sm-2">
              <input type="submit" name="name" value="Submit" class="btn btn-success btn-lg btn-raised">
            </div>
        </form>
      </div>
    </div>
</div>

@endsection
