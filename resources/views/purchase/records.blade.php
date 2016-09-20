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
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/purchase/"><button type="button" class="btn btn-primary btn-raised">新增採購 / New Purchase</button></a>
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
                <div class="btn-group">
                  <button type="button" target="center" class="btn btn-info btn-raised" onclick="window.location.href='{{ URL::route('purchase.show', $record->id) }}'">查看 / Details</button>
                  <button type="button" class="btn btn-info dropdown-toggle btn-raised" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <li align="center">
                      <button type="button" target="center" class="btn btn-success" onclick="window.location.href='{{ URL::route('purchase.edit', $record->id) }}'">修改 / Modify</button>
                    </li>
                    <li align="center">
                      <form class="form-horizontal" action="{{ url('/purchase/'.$record->id)}}" method="post" role="form">
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
