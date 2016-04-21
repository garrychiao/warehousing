@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          採購單 / Purchasing
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          採購紀錄 / Purchasing Records
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/purchase/"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
        </div>
      </div>
        <div class="col-sm-10 col-sm-offset-1">
          @if(count($records)>0)
          <table class="table table-condensed table-bordered table-hover">
            <tr>
              <td>訂單編號</td>
              <td>採購日期</td>
              <td>供應廠商</td>
              <td>採購項目</td>
              <td>總金額</td>
              <td>內容</td>
            </tr>
            @foreach($records as $record)
            <tr>
              <td>{{ $record->order_id }}</td>
              <td>{{ $record->purchase_date }}</td>
              <td>{{ $record->supplier_name }}</td>
              <td>{{ $record->count }}</td>
              <td>NT$ {{ $record->amount }}</td>
              <td>
                <button type="button" target="center" class="btn btn-info btn-sm btn-raised" onclick="window.location.href='{{ URL::route('purchase.show', $record->id) }}'">Details</button>
              </td>
            </tr>
            @endforeach
          </table>
          @endif
        </div>
    </div>
</div>
@endsection
