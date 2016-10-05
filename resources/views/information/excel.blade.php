<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen">
tr td {
  wrap-text: true;
}
</style>
<table>

<!--Purchase Records Informations-->
@if($type == "invoices_purchase")
  <tr>
    <th class="col-sm-1">ID</th>
    <th class="col-sm-1">採購日期 / Purchased Date</th>
    <th class="col-sm-1">供應廠商 / Supplier</th>
    <th class="col-sm-2">進貨項目 / Item</th>
    <th class="col-sm-1">數量 / Quantity</th>
    <th class="col-sm-1">金額 / Money</th>
    <th class="col-sm-1">總金額 / Total</th>
    <th class="col-sm-1">交貨日期 / Delivery Date</th>
  </tr>
  @forelse($information as $pur)
  <tr>
    <td valign="middle">{{ $pur->order_id }}</td>
    <td valign="middle">{{ $pur->purchase_date }}</td>
    <td valign="middle">{{ $pur->supplier_name }}</td>
    <!--purchased inventories-->
    <td valign="middle">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->purchase_records_id == $pur->id)
        {{$inv_rec->item_name}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->purchase_records_id == $pur->id)
        {{$inv_rec->quantity}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->purchase_records_id == $pur->id)
        {{ number_format( $inv_rec->total , 2 ) }}<br>
        @endif
      @endforeach
    </td>
    <td valign="middle">
      <strong>{{ number_format($pur->amount,2) }}</strong>
    </td>
    <td valign="middle">{{ $pur->delivery_date}}</td>
  </tr>
  @empty
  <tr>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
  </tr>
  @endforelse
@elseif($type == "invoices_proforma")
  <tr>
    <th class="col-sm-1">ID</th>
    <th class="col-sm-1">日期 / Date</th>
    <th class="col-sm-1">客戶 / Customer</th>
    <th class="col-sm-2">項目 / Item</th>
    <th class="col-sm-1">數量 / Quantity</th>
    <th class="col-sm-1">金額 / Money</th>
    <th class="col-sm-1">總金額 / Total</th>
    <th class="col-sm-1">到期 / Due Date</th>
  </tr>
  @forelse($information as $pro)
  <tr>
    <td valign="middle">{{ $pro->order_id}}</td>
    <td valign="middle">{{ $pro->create_date}}</td>
    <td valign="middle">{{ $pro->eng_name}}</td>
    <!--purchased inventories-->
    <td valign="middle">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->proforma_invoice_id == $pro->id)
        {{$inv_rec->item_name}} {{ $inv_rec->kits_name}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->proforma_invoice_id == $pro->id)
        {{$inv_rec->quantity}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->proforma_invoice_id == $pro->id)
        {{ number_format( $inv_rec->total , 2 ) }}<br>
        @endif
      @endforeach
    </td>
    <td valign="middle">
      <strong>{{ number_format($pro->amount,2) }}</strong>
    </td>
    <td valign="middle">{{ $pro->due_date}}</td>
  </tr>
  @empty
  <tr>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
  </tr>
  @endforelse
@elseif($type == "invoices_commercial")
  <tr>
    <th class="col-sm-1">ID</th>
    <th class="col-sm-1">日期 / Date</th>
    <th class="col-sm-1">客戶 / Customer</th>
    <th class="col-sm-2">項目 / Item</th>
    <th class="col-sm-1">數量 / Quantity</th>
    <th class="col-sm-1">金額 / Total</th>
    <th class="col-sm-1">出貨到期 / Export Date</th>
  </tr>
  @forelse($information as $pro)
  <tr>
    <td valign="middle">{{ $pro->order_id}}</td>
    <td valign="middle">{{ $pro->create_date}}</td>
    <td valign="middle">{{ $pro->eng_name}}</td>
    <!--purchased inventories-->
    <td valign="middle">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->commercial_invoice_id == $pro->id)
        {{$inv_rec->item_name}} {{ $inv_rec->kits_name}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->commercial_invoice_id == $pro->id)
        {{$inv_rec->quantity}}<br>
        @endif
      @endforeach
    </td>
    <td align="right">
      @foreach($invoice_records as $inv_rec)
        @if($inv_rec->commercial_invoice_id == $pro->id)
        {{ number_format( $inv_rec->total , 2 ) }}<br>
        @endif
      @endforeach
      <strong>{{ number_format($pro->amount,2) }}</strong>
    </td>
    <td valign="middle">{{ $pro->export_date}}</td>
  </tr>
  @empty
  <tr>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
    <td valign="middle">無資料</td>
  </tr>
  @endforelse
@endif

</table>
