<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
  <!--Purchase Records Informations-->
  <tr>
    <td class="col-sm-1">ID</td>
    <td class="col-sm-1">採購日期</td>
    <td class="col-sm-1">交貨日期</td>
    <td class="col-sm-1">供應廠商</td>
    <td class="col-sm-2">進貨項目</td>
    <td class="col-sm-1">數量</td>
    <td class="col-sm-1">金額</td>
  </tr>
  @forelse($information as $pur)
  <tr>
    <td rowspan="{{ $pur->count }}">{{ $pur->order_id}}</td>
    <td rowspan="{{ $pur->count }}">{{ $pur->purchase_date}}</td>
    <td rowspan="{{ $pur->count }}">{{ $pur->delivery_date}}</td>
    <td rowspan="{{ $pur->count }}">{{ $pur->supplier_name}}</td>
    <!--purchased inventories-->
      @foreach($invoice_records as $key=>$inv_rec)
        @if($inv_rec->purchase_records_id == $pur->id)
          @if($key == 0)
          <td>{{ $inv_rec->item_name }}</td>
          <td>{{ $inv_rec->quantity }}</td>
          <td>{{ number_format( $inv_rec->total , 2 ) }}</td>
        </tr>
        @else
          <tr>
            <td>{{ $inv_rec->item_name }}</td>
            <td>{{ $inv_rec->quantity }}</td>
            <td>{{ number_format( $inv_rec->total , 2 ) }}</td>
          </tr>
          @endif
        @endif
      @endforeach
      <tr>
        <td colspan="3">

        </td>
      </tr>
  @empty
  <tr>
    <td>無資料</td>
    <td>無資料</td>
    <td>無資料</td>
    <td>無資料</td>
    <td>無資料</td>
    <td>無資料</td>
    <td>無資料</td>
  </tr>
  @endforelse

</table>
