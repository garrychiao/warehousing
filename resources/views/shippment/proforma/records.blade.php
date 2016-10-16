@extends('layouts.app')
<!--Proforma Invoice Records-->
@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          報價單 / Proforma Invoice
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          報價紀錄 / Proforma Invoice Records
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/shippment"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
          <a href="/shippment/proforma"><button type="button" class="btn btn-primary btn-raised">新增報價單 / New Proforma Invoice</button></a>
        </div>
      </div>
        <div class="col-sm-12">
          @if(count($records)>0)
          <table class="table table-condensed table-bordered table-hover">
            <tr class="success">
              <th class="col-sm-1">訂單編號 / ID</th>
              <th class="col-sm-1">客戶 / Customer</th>
              <th class="col-sm-1">聯絡人 / Contact</th>
              <th class="col-sm-1">輸出至出貨單 / Converted</th>
              <th class="col-sm-1">報價日期 / Create Date</th>
              <th class="col-sm-1">到期日 / Due Date</th>
              <th class="col-sm-3">報價項目 / Item</th>
              <th class="col-sm-1">報價金額 / Total</th>
              <th class="col-sm-2">內容 / Info</th>
            </tr>
            @foreach($records as $record)
            <tr>
              <td>{{ $record->order_id }}</td>
              <td>{{ $record->eng_name }}</br>{{ $record->chi_name }}</td>
              <td>{{ $record->contact_person }}</td>
              <td>
                @if( $record->converted == true)
                  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                @else
                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                @endif
              </td>
              <td>{{ $record->create_date }}</td>
              <td>{{ $record->due_date }}</td>
              <td>
                @foreach($inv_records as $inv_rec)
                  @if($inv_rec->proforma_invoice_id == $record->id)
                  {{$inv_rec->item_name}}{{$inv_rec->kits_name}}<br>
                  @endif
                @endforeach
              </td>
              <td align="right">
                @foreach($inv_records as $inv_rec)
                  @if($inv_rec->proforma_invoice_id == $record->id)
                  {{ number_format($inv_rec->total,2) }}<br>
                  @endif
                @endforeach
                <strong>{{ number_format($record->amount,2) }}</strong>
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('shippment.proforma.show', $record->id) }}'">內容 / Details</button>
                  <button type="button" class="btn btn-info dropdown-toggle btn-raised btn-sm " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <li align="center">
                      <button type="button" target="center" class="btn btn-success" onclick="window.location.href='{{ URL::route('shippment.proforma.edit', $record->id) }}'">修改 / Modify</button>
                      @if( $record->converted == false && $record->overdue == false)
                        <a type="button" href="{{ url('/convert/'.$record->id)}}" class="btn btn-warning">轉換 / Convert</a>
                      @endif
                    </li>
                    <li align="center">
                      <form class="form-horizontal" action="{{ url('/shippment/proforma/'.$record->id)}}" method="post" role="form">
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
