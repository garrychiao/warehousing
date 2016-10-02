@extends('layouts.app')
<!--Commercial Invoice Records-->
@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          出貨單 / Commercial Invoice
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          出貨紀錄 / Commercial Invoice Records
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/shippment"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
          <a href="/shippment/commercial"><button type="button" class="btn btn-primary btn-raised">新增出貨單 / New Commercial Invoice</button></a>
        </div>
      </div>
        <div class="col-sm-12">
          @if(count($records)>0)
          <table class="table table-condensed table-bordered table-hover">
            <tr>
              <td class="col-sm-1">訂單編號</td>
              <td class="col-sm-1">客戶</td>
              <td class="col-sm-1">聯絡人</td>
              <td class="col-sm-1">參考報價單</td>
              <td class="col-sm-1">出貨日期</td>
              <td class="col-sm-2">出貨項目</td>
              <td class="col-sm-1">金額</td>
              <td class="col-sm-1">詳細內容</td>
            </tr>
            @foreach($records as $record)
            <tr>
              <td>{{ $record->order_id }}</td>
              <td>{{ $record->eng_name }}</td>
              <td>{{ $record->contact_person }}</td>
              <td>{{ $record->reference }}</td>
              <td>{{ $record->export_date }}</td>
              <td>
                @foreach($inv_records as $inv_rec)
                  @if($inv_rec->commercial_invoice_id == $record->id)
                  {{$inv_rec->item_name}}{{$inv_rec->kits_name}}<br>
                  @endif
                @endforeach
              </td>
              <td align="right">
                @foreach($inv_records as $inv_rec)
                  @if($inv_rec->commercial_invoice_id == $record->id)
                  {{ number_format($inv_rec->total,2) }}<br>
                  @endif
                @endforeach
                <strong>{{ number_format($record->final_total,2) }}</strong>
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('shippment.commercial.show', $record->id) }}'">內容 / Details</button>
                  <button type="button" class="btn btn-info dropdown-toggle btn-raised btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <li align="center">
                      <button type="button" target="center" class="btn btn-success" onclick="window.location.href='{{ URL::route('shippment.commercial.edit', $record->id) }}'">修改 / Modify</button>
                    </li>
                    <li align="center">
                      <form class="form-horizontal" action="{{ url('/shippment/commercial/'.$record->id)}}" method="post" role="form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete" />
                        <input type="submit" class="btn btn-danger" value="刪除 / Delete">
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </table>
          {{ $records->links() }}
          @endif
        </div>
    </div>
</div>
@endsection
