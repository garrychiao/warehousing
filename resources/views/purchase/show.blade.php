@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
          @if(count($records)>0)
          <div class="hidden-print">
            <div class="alert alert-success" role="alert">
              採購單 / Purchasing
              <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
              採購紀錄 / Purchasing Records
              <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
              {{$records->order_id}}
            </div>
            <div class="btn-group btn-group-justified">
              <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
              <a href="{{ url('/purchase/create') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
              <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
              <a><button type="button" target="center" class="btn btn-primary btn-raised" onclick="window.location.href='{{ URL::route('purchase.edit', $records->id) }}'">修改 / Modify</button></a>
              <a href="{{ url('/excel/purchase/'.$records->id) }}"><button type="button" class="btn btn-primary btn-raised">Excel</button></a>
            </div>
          </div>
          <table class="table table-condensed table-bordered table-hover" id="print_area">
            <tr>
              <th colspan="6"><h3 align="center">{{ $mycompany->name }}<br>{{ $mycompany->eng_name }}</h3>
              <small>採購日期：{{$records->purchase_date}}</small></th>
            </tr>
            <tr>
              <td>訂單編號</td>
              <td colspan="2">{{ $records->order_id }}</td>
              <td>交貨日期</td>
              <td colspan="2">{{ $records->delivery_date}}</td>
            </tr>
            <tr>
              <td>供應廠商</td>
              <td colspan="2">{{ $records->supplier_name }}</td>
              <td>付款條件</td>
              <td colspan="2">{{ $records->payment_terms }}</td>
            </tr>
            <tr>
              <td>公司地址</td>
              <td colspan="2">{{ $mycompany->address }}</td>
              <td>統一編號</td>
              <td colspan="2">{{ $mycompany->EIN }}</td>
            </tr>
            <tr>
              <td>聯絡人</td>
              <td colspan="2">{{ $mycompany->contact_person }}</td>
              <td>電話</td>
              <td colspan="2">{{ $mycompany->cell_phone }}</td>
            </tr>
            <tr class="success">
              <td>產品編號</td>
              <td>產品名稱</td>
              <td>訂單數量</td>
              <td>單價</td>
              <td>金額</td>
              <td>備註</td>
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
              <td colspan="5">{{ $records->delivery_address}}</td>
            </tr>
            <tr>
              <td>包裝方式</td>
              <td colspan="5">{{ $records->packing}}</td>
            </tr>
            <tr>
              <td>出貨樣</td>
              <td colspan="5">{{ $records->shipping_sample}}</td>
            </tr>
            <tr>
              <td>注意事項</td>
              <td colspan="5">{{ $records->precautions}}</td>
            </tr>
          </table>
          @endif
        </div>
    </div>
</div>
@endsection
