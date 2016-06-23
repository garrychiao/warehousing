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
        <div class="col-sm-10 col-sm-offset-1">
          @if(count($records)>0)
          <table class="table table-condensed table-bordered table-hover">
            <tr>
              <td>訂單編號</td>
              <td>參考報價單</td>
              <td>客戶</td>
              <td>聯絡人</td>
              <td>報價日期</td>
              <td>報價金額</td>
              <td>詳細內容</td>
            </tr>
            @foreach($records as $record)
            <tr>
              <td>{{ $record->order_id }}</td>
              <td>{{ $record->reference }}</td>
              <td>{{ $record->chi_name }}</td>
              <td>{{ $record->contact_person }}</td>
              <td>{{ $record->create_date }}</td>
              <td>NT$ {{ number_format($record->final_total,2) }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" target="center" class="btn btn-info btn-raised" onclick="window.location.href='{{ URL::route('shippment.commercial.show', $record->id) }}'">內容 / Details</button>
                  <button type="button" class="btn btn-info dropdown-toggle btn-raised" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          @endif
        </div>
    </div>
</div>
@endsection
