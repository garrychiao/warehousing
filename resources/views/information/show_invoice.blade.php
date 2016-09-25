@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success hidden-print" role="alert">
          資料輸出 / Data Export
          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
          {{ ucfirst($type) }}
        </div>
        <div class="btn-group btn-group-justified hidden-print">
          <div class="col-sm-6">
            <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
            <a href="{{ url('/information')}}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
            <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
          </div>
          <div class="col-sm-2">
            <form class="form-horizontal" action="{{ url('/excel')}}" method="post" role="form">
              {!! csrf_field() !!}
              <input type="hidden" name="export_type" value="{{ $type }}" />
              @forelse($information as $info)
              <input type="hidden" name="item_id[]" value="{{ $info->id }}" />
              @empty

              @endforelse
              <input type="submit" class="btn btn-primary btn-raised btn-block" value="Excel">
            </form>
          </div>
          <a href="{{ url('/test')}}"><button type="button" class="btn btn-primary btn-raised">test</button></a>
        </div>
        <div class="col-sm-12">
          <table class="table table-condensed table-bordered table-striped">
            <tr>
              <td colspan="2" align="center">
                <h2>{{$mycompany->eng_name}}</h2>
              </td>
            </tr>
            <tr align="center">
              <td>
                @if($type == "invoices_purchase")
                <h4>Purchased Informations</h4>
                @elseif($type == "invoices_proforma")
                <h4>Proforma Invoices Informations</h4>
                @elseif($type == "invoices_commercial")
                <h4>Commercial Invoices Informations</h4>
                @endif
              </td>
              <td>
                {{$mycompany->eng_address}}
                {{$mycompany->email}}<br>Tel. {{$mycompany->phone}}<br> {{$mycompany->cell_phone}}
              </td>
            </tr>
          </table>
          <table class="table table-condensed table-bordered table-hover table table-striped">

          <!--Purchase Records Informations-->
          @if($type == "invoices_purchase")
          <tr>
            <th class="col-sm-1">ID</th>
            <th class="col-sm-1">採購日期</th>
            <th class="col-sm-1">供應廠商</th>
            <th class="col-sm-2">進貨項目</th>
            <th class="col-sm-1">數量</th>
            <th class="col-sm-1">金額</th>
            <th class="col-sm-1">交貨日期</th>
          </tr>
          @forelse($information as $pur)
          <tr>
            <td>{{ $pur->order_id}}</td>
            <td>{{ $pur->purchase_date}}</td>
            <td>{{ $pur->supplier_name}}</td>
            <!--purchased inventories-->
            <td>
              @foreach($invoice_records as $inv_rec)
                @if($inv_rec->purchase_records_id == $pur->id)
                {{$inv_rec->item_name}}<br>
                @endif
              @endforeach
            </td>
            <td align="right">
              @foreach($invoice_records as $inv_rec)
                @if($inv_rec->purchase_records_id == $pur->id)
                {{$inv_rec->quantity}}<br>
                @endif
              @endforeach
            </td>
            <td align="right">
              @foreach($invoice_records as $inv_rec)
                @if($inv_rec->purchase_records_id == $pur->id)
                {{ number_format( $inv_rec->total , 2 ) }}<br>
                @endif
              @endforeach
              <strong>{{ number_format($pur->amount,2) }}</strong>
            </td>
            <td>{{ $pur->delivery_date}}</td>
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
          @endif

          </table>
        </div>
      </div>
    </div>
</div>
@endsection
