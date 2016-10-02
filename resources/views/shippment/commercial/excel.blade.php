<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen">
tr td {
  wrap-text: true;
}
</style>
@foreach($records as $record)
<table>
  <tr>
    <td colspan="8" class="col-sm-10" align="center">
      <h2>{{$mycompany->eng_name}}</h2>{{$mycompany->eng_address}}<br>
      {{$mycompany->email}}<br>Tel. {{$mycompany->phone}}{{$mycompany->cell_phone}}
      <h3>Commercial Invoice</h3>
    </td>
  </tr>
  <tr>
    <td colspan="8" align="right">Date : {{ $record->create_date }}</td>
  </tr>
  <tr class="success">
    <th colspan="2" style="width:25px;">Date of Export</th>
    <th colspan="2" style="width:25px;">Terms of sale</th>
    <th colspan="2" style="width:25px;">Reference</th>
    <th colspan="2" style="width:25px;">Currency</th>
  </tr>
  <tr>
    <td colspan="2">{{ $record->export_date}}</td>
    <td colspan="2">{{ $record->terms_of_sale }}</td>
    <td colspan="2">{{ $record->reference }}</td>
    <td colspan="2">{{ $record->currency }}</td>
  </tr>
  <tr class="success">
    <th colspan="4"> Shipper/Exporter :</th>
    <th colspan="4">Consignee : </th>
  </tr>
  <tr>
    <td colspan="4" style="height:60px;">{!!nl2br(e($record->exporter))!!}</td>
    <td colspan="4" style="height:60px;">{!!nl2br(e($record->consignee))!!}</td>
  </tr>
  <tr class="success">
    <th colspan="4">Country of Ultimate Destination</th>
    <th colspan="4">Notify Party :</th>
  </tr>
  <tr>
    <td colspan="4">{{ $record->destination_country}}</td>
    <td colspan="4" rowspan="5">{!!nl2br(e($record->notify_party))!!}</td>
  </tr>
  <tr class="success">
    <th colspan="4" class="col-sm-2">Country Of Manufacture</th>
  </tr>
  <tr>
    <td colspan="4">{{ $record->manufacture_country}}</td>
  </tr>
  <tr class="success">
    <th colspan="4" class="col-sm-2">International Airwaybill Number</th>
  </tr>
  <tr>
    <td colspan="4">{{ $record->airwaybill_number}}</td>
  </tr>
  <tr class="success">
    <th>Item Code</th><th colspan="3">Description</th><th>Weight (kg)</th><th>Quantity</th><th>Price Each</th><th>Amount</th>
  </tr>
  @if(count($inventory_kits_records)>0)
    @foreach($inventory_kits_records as $kit)
    <tr>
      <td>{{$kit->item_id}}</td>
      <td colspan="3">{{$kit->kits_description}}</td>
      <td>{{number_format($kit->weight,2)}}</td>
      <td>{{number_format($kit->quantity,0)}}</td>
      <td>{{number_format($kit->unit_price,2)}}</td>
      <td align="right">{{number_format($kit->total,2)}}</td>
    </tr>
    @endforeach
  @endif
  @if(count($inventory)>0)
    @foreach($inventory as $inv)
      <tr>
        <td>{{$inv->item_id}}</td>
        <td colspan="3">{{$inv->descriptions}}</td>
        <td>{{$inv->weight}}</td>
        <td>{{$inv->quantity}}</td>
        <td>{{number_format($inv->unit_price,2)}}</td>
        <td align="right">{{number_format($inv->total,2)}}</td>
      </tr>
    @endforeach
    <tr class="success">
      <td colspan="4" align="right"><strong>Sub-Total : </strong></td>
      <td align="right">{{number_format($total->weight)}}</td>
      <td align="right">{{number_format($total->quantity)}}</td>
      <td align="right">{{number_format($total->unit_price,2)}}</td>
      <td align="right">{{number_format($total->total,2)}}</td>
    </tr>
  @endif
    <tr>
      <td colspan="6" align="right"><strong>Shipping : </strong></td>
      <td colspan="2" align="right">{{number_format($record->cost_shipping,2)}}</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><strong>Insurance Costs : </strong></td>
      <td colspan="2" align="right">{{number_format($record->cost_insurance,2)}}</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><strong>Additional Costs : </strong></td>
      <td colspan="2" align="right">{{number_format($record->cost_additional,2)}}</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><h4>Total Incoive Value : </h4></td>
      <td colspan="2" align="right"><h4>{{number_format($record->cost_shipping+$record->cost_insurance+$record->cost_additional+$total->total,2)}}</h4></td>
    </tr>
  <tr class="success">
    <th colspan="2">Phone#</th>
    <th colspan="2">E-mail</th>
    <th colspan="2">Fax#</th>
    <th colspan="2">Web Site</th>
  </tr>
  <tr>
    <td colspan="2">{{$mycompany->phone}}</td>
    <td colspan="2">{{$mycompany->email}}</td>
    <td colspan="2">{{$mycompany->fax}}</td>
    <td colspan="2">{{$mycompany->website}}</td>
  </tr>
</table>
@endforeach
