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
          <a href="/shippment/proforma"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
        </div>
      </div>
        <div class="col-sm-10 col-sm-offset-1">
          @if(count($records)>0)
          <table class="table table-condensed table-bordered table-hover">
            <tr>
              <td>訂單編號</td>
              <td>客戶</td>
              <td>聯絡人</td>
              <td>報價日期</td>
              <td>報價金額</td>
              <td>詳細內容</td>
            </tr>
            @foreach($records as $record)
            <tr>
              <td>{{ $record->order_id }}</td>
              <td>{{ $record->company_name }}</td>
              <td>{{ $record->contact_person }}</td>
              <td>{{ $record->create_date }}</td>
              <td>NT$ {{ $record->amount }}</td>
              <td>
                <button type="button" target="center" class="btn btn-info btn-sm btn-raised" onclick="window.location.href='{{ URL::route('shippment.proforma.show', $record->id) }}'">Details</button>
              </td>
            </tr>
            @endforeach
          </table>
          @endif
        </div>
    </div>
</div>
@endsection
