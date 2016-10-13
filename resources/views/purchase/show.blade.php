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
              <th class="success">訂單編號</th>
              <td colspan="2">{{ $records->order_id }}</td>
              <th class="success">交貨日期</th>
              <td colspan="2">{{ $records->delivery_date}}</td>
            </tr>
            <tr>
              <th class="success">供應廠商</th>
              <td colspan="2">{{ $records->supplier_name }}</td>
              <th class="success">付款條件</th>
              <td colspan="2">{{ $records->payment_terms }}</td>
            </tr>
            <tr>
              <th class="success">公司地址</th>
              <td colspan="2">{{ $mycompany->address }}</td>
              <th class="success">統一編號</th>
              <td colspan="2">{{ $mycompany->EIN }}</td>
            </tr>
            <tr>
              <th class="success">聯絡人</th>
              <td colspan="2">{{ $mycompany->contact_person }}</td>
              <th class="success">電話</th>
              <td colspan="2">{{ $mycompany->cell_phone }}</td>
            </tr>
            <tr class="success">
              <th>產品編號</th>
              <th>產品名稱</th>
              <th>訂單數量</th>
              <th>單價</th>
              <th>金額</th>
              <th>備註</th>
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
                <th colspan="4" align="right">總計：</th>
                <td align="right">{{ number_format($total,2) }}</td>
                <td></td>
              </tr>
            @endif
            <tr>
              <th class="success">送貨地點</th>
              <td colspan="5">{{ $records->delivery_address}}</td>
            </tr>
            <tr>
              <th class="success">包裝方式</th>
              <td colspan="5">{{ $records->packing}}</td>
            </tr>
            <tr>
              <th class="success">出貨樣</th>
              <td colspan="5">{{ $records->shipping_sample}}</td>
            </tr>
            <tr>
              <th class="success">注意事項</th>
              <td colspan="5">{{ $records->precautions}}</td>
            </tr>
          </table>
          @endif
        </div>
    </div>
</div>
@endsection
