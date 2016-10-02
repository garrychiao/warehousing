<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen">
tr td {
  wrap-text: true;
}
</style>
@foreach($records as $record)
<table class="table table-condensed table-bordered table-hover">
  <tr class="visible-print"><th colspan="7">Proforma Invoice</th></tr>
  <tr>
    <td colspan="6">
      <h4>{{$mycompany->eng_name}}</h4>{{$mycompany->eng_address}}<br>
      {{$mycompany->email}}<br>Tel. +886{{$mycompany->phone}} +886{{$mycompany->cell_phone}}
    </td>
    <td colspan="2">
      <h4>Proforma Invoice</h4>
      <small>Date : {{$record->create_date}}<br>
      Invoice# : {{$record->order_id}}</small>
    </td>
  </tr>
  <tr class="success">
    <th colspan="4" class="col-sm-6">Bill To</th>
    <th colspan="4" class="col-sm-6">Ship To</th>
  </tr>
  <tr>
    <!--make newline character working -->
    <td colspan="4" style="height:60px;">{!!nl2br(e($record->bill_to))!!}</td>
    <td colspan="4" style="height:60px;">{!!nl2br(e($record->ship_to))!!}</td>
  </tr>
  <tr class="success">
    <th style="width:20px;">P.O. Number</th>
    <th style="width:20px;">Payment Terms</th>
    <th style="width:20px;">Rep</th>
    <th style="width:20px;">Ship</th>
    <th style="width:20px;">Via</th>
    <th style="width:20px;">Shipping Term</th>
    <th style="width:20px;">Due Date</th>
  </tr>
  <tr>
    <td>{{$record->POnumber}}</td>
    <td>{{$record->payment_terms}}</td>
    <td>{{$record->rep}}</td>
    <td>{{$record->ship}}</td>
    <td>{{$record->via}}</td>
    <td>{{$record->FOB}}</td>
    <td>{{$record->due_date}}</td>
  </tr>
  <tr class="success">
    <th>Quantity</th><th>Item Code</th><th colspan="2">Description</th><th>Weight</th><th>Price Each</th><th>Amount</th>
  </tr>
  @if(count($inventory_kits_records)>0)
    @foreach($inventory_kits_records as $kit)
    <tr>
      <td>{{$kit->quantity}}</td>
      <td>{{$kit->item_id}}</td>
      <td colspan="2">{{$kit->kits_description}}</td>
      <td>{{number_format($kit->weight,2)}}</td>
      <td>{{number_format($kit->unit_price,2)}}</td>
      <td>{{number_format($kit->total,2)}}</td>
    </tr>
    @endforeach
  @endif
  @if(count($inventory)>0)
    @foreach($inventory as $inv)
      <tr>
        <td>{{$inv->quantity}}</td>
        <td>{{$inv->item_id}}</td>
        <td colspan="2">{{$inv->descriptions}}</td>
        <td>{{number_format($inv->weight,2)}}</td>
        <td>{{number_format($inv->unit_price,2)}}</td>
        <td>{{number_format($inv->total,2)}}</td>
      </tr>
    @endforeach
    <tr>
      <td>1</td>
      <td>S&H</td>
      <td colspan="3">Shipping and Handling Cost</td>
      <td>{{$record->sandh}}</td>
      <td>{{$record->sandh}}</td>
    </tr>
    <tr>
      <td colspan="5"></td>
      <td align="right"><strong>Total : </strong></td>
      <td colspan="2">{{number_format($total,2)}}</td>
    </tr>
  @endif
  <tr class="success">
    <th>Phone#</th><th>Fax#</th><th colspan="3">E-mail</th><th colspan="3">Web Site</th>
  </tr>
  <tr>
    <td>{{$mycompany->phone}}</td>
    <td>{{$mycompany->fax}}</td>
    <td colspan="3">{{$mycompany->email}}</td>
    <td colspan="3">{{$mycompany->website}}</td>
  </tr>
</table>
@endforeach
