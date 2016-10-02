<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

@if(count($records)>0)
  @foreach($records as $record)
  <table>
    <tr>
      <th colspan="6">
        <h1 align="center">{{ $mycompany->name }}<br>{{ $mycompany->eng_name }}</h1>
      </th>
    </tr>
    <tr>
      <td colspan="6">
        <small>採購日期：{{$record->purchase_date}}</small>
      </td>
    </tr>
    <tr>
      <td width="25"><b>訂單編號</b></td>
      <td width="50" colspan="2">{{ $record->order_id }}</td>
      <td width="25"><b>交貨日期</b></td>
      <td width="50" colspan="2">{{ $record->delivery_date}}</td>
    </tr>
    <tr>
      <td width="25"><b>供應廠商</b></td>
      <td width="50" colspan="2">{{ $record->supplier_name }}</td>
      <td width="25"><b>付款條件</b></td>
      <td width="50" colspan="2">{{ $record->payment_terms }}</td>
    </tr>
    <tr>
      <td width="25"><b>公司地址</b></td>
      <td width="50" colspan="2">{{ $mycompany->address }}</td>
      <td width="25"><b>統一編號</b></td>
      <td width="50" colspan="2">{{ $mycompany->EIN }}</td>
    </tr>
    <tr>
      <td width="25"><b>聯絡人</b></td>
      <td width="50" colspan="2">{{ $mycompany->contact_person }}</td>
      <td width="25"><b>電話</b></td>
      <td width="50" colspan="2">{{ $mycompany->cell_phone }}</td>
    </tr>
    <tr class="success">
      <td width="25"><b>產品編號</b></td>
      <td width="25"><b>產品名稱</b></td>
      <td width="25"><b>訂單數量</b></td>
      <td width="25"><b>單價</b></td>
      <td width="25"><b>金額</b></td>
      <td width="25"><b>備註</b></td>
    </tr>
    @if(count($inventory)>0)
      @foreach($inventory as $inv)
        <tr>
          <td>{{ $inv->item_id }}</td>
          <td>{{ $inv->item_name }}</td>
          <td>{{ $inv->quantity }}</td>
          <td align="right">{{ $inv->unit_price }}</td>
          <td align="right">{{ number_format($inv->total,2) }}</td>
          <td>{{ $inv->remark }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="4" align="right">總計：</td>
        <td align="right">{{ number_format($total,2) }}</td>
        <td></td>
      </tr>
    @endif
    <tr>
      <td>送貨地點</td>
      <td colspan="5">{{ $record->delivery_address}}</td>
    </tr>
    <tr>
      <td>包裝方式</td>
      <td colspan="5">{{ $record->packing}}</td>
    </tr>
    <tr>
      <td>出貨樣</td>
      <td colspan="5">{{ $record->shipping_sample}}</td>
    </tr>
    <tr>
      <td>注意事項</td>
      <td colspan="5">{{ $record->precautions}}</td>
    </tr>
  </table>
  @endforeach
@endif
