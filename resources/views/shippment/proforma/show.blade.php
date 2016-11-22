@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
          <div class="hidden-print">
            <div class="col-sm-12">
              <div class="alert alert-success" role="alert">
                報價單 / Proforma Invoice
                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                報價紀錄 / Proforma Invoice Records
                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                {{$records->order_id}}
              </div>
              <div class="btn-group btn-group-justified">
                <a href="{{ url('/shippment/proforma/create') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
                <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
                <a><button type="button" target="center" class="btn btn-primary btn-raised" onclick="window.location.href='{{ URL::route('shippment.proforma.edit', $records->id) }}'">修改 / Modify</button></a>
                <a href="{{ url('/excel/proforma/'.$records->id) }}"><button type="button" class="btn btn-primary btn-raised">Excel</button></a>
              </div>
            </div>
          </div>
          <table class="table table-condensed table-bordered table-hover">
            <tr class="visible-print"><th colspan="7">Proforma Invoice</th></tr>
            <tr>
              <td colspan="2" align="center">
                @if(isset($mycompany->img_url))
                <img src="../../{{ $mycompany->img_url }}" alt="" width="120px" />
                @endif
              </td>
              <td colspan="4">
                <h4>{{$mycompany->eng_name}}</h4>{{$mycompany->eng_address}}<br>
                {{$mycompany->email}}<br>Tel. +886{{$mycompany->phone}} +886{{$mycompany->cell_phone}}
              </td>
              <td colspan="2">
                <h4>Proforma Invoice</h4>
                <small>Date : {{$records->create_date}}<br>
                Invoice# : {{$records->order_id}}</small>
              </td>
            </tr>
            <tr class="success">
              <th colspan="4" class="col-sm-6">Bill To</th>
              <th colspan="4" class="col-sm-6">Ship To</th>
            </tr>
            <tr>
              <!--make newline character working -->
              <td colspan="4">{!!nl2br(e($records->bill_to))!!}</td>
              <td colspan="4">{!!nl2br(e($records->ship_to))!!}</td>
            </tr>
          </table>
          <table class="table table-condensed table-bordered table-hover">
            <tr class="success">
              <th class="col-sm-1">P.O. Number</th>
              <th class="col-sm-1">Payment Terms</th>
              <th class="col-sm-1">Rep</th>
              <th class="col-sm-1">Ship</th>
              <th class="col-sm-1">Via</th>
              <th class="col-sm-1">Shipping Term</th>
              <th class="col-sm-1">Due Date</th>
            </tr>
            <tr>
              <td>{{$records->POnumber}}</td>
              <td>{{$records->payment_terms}}</td>
              <td>{{$records->rep}}</td>
              <td>{{$records->ship}}</td>
              <td>{{$records->via}}</td>
              <td>{{$records->FOB}}</td>
              <td>{{$records->due_date}}</td>
            </tr>
          </table>
          <table class="table table-condensed table-bordered table-hover">
            <tr class="success">
              <th>Quantity</th><th>Item Code</th><th colspan="2">Item Name</th>
              <!--<th>Description</th>--><th>Weight</th><th>Price Each</th><th>Amount</th>
            </tr>
            @if(count($inventory_kits_records)>0)
              @foreach($inventory_kits_records as $kit)
              <tr>
                <td>{{$kit->quantity}}</td>
                <td>{{$kit->item_id}}</td>
                <td colspan="2">{{$kit->kits_name}}</td>
                <!--<td>{{$kit->kits_description}}</td>-->
                <td>{{number_format($kit->weight,2)}}</td>
                <td>{{number_format($kit->unit_price,2)}}</td>
                <td>{{number_format($kit->total,2)}}</td>
              </tr>
              @endforeach
            @endif
            @if(count($inventory)>0)
              @foreach($inventory as $inv)
                <tr>
                  <td>{{$inv->quantity}}</td>
                  <td>{{$inv->item_id}}</td>
                  <td colspan="2">{{$inv->item_name}}</td>
                  <!--<td>{{$inv->description}}</td>-->
                  <td>{{number_format($inv->weight,2)}}</td>
                  <td>{{number_format($inv->unit_price,2)}}</td>
                  <td>{{number_format($inv->total,2)}}</td>
                </tr>
              @endforeach
            @endif
              <tr>
                <td>1</td>
                <td>S&H</td>
                <td colspan="3">Shipping and Handling Cost</td>
                <td>{{$records->sandh}}</td>
                <td>{{$records->sandh}}</td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td align="right"><strong>Total Weight : </strong></td>
                <td>{{number_format($total_weight,2)}}</td>
                <td align="right"><strong>Total : </strong></td>
                <td colspan="2">{{number_format($total,2)}}</td>
              </tr>
              @if(isset($records->quotation))
              <tr>
                <td align="right" colspan="2">
                  Quatation :
                </td>
                <td colspan="5">{{$records->quotation}}</td>
              </tr>
              @endif
          </table>
          <table class="table table-condensed table-bordered table-hover">
            <tr class="success">
              <th>Phone#</th><th>Fax#</th><th colspan="3">E-mail</th><th colspan="3">Web Site</th>
            </tr>
            <tr>
              <td>{{$mycompany->phone}}</td>
              <td>{{$mycompany->fax}}</td>
              <td colspan="3">{{$mycompany->email}}</td>
              <td colspan="3">{{$mycompany->website}}</td>
            </tr>
          </table>
        </div>
    </div>
</div>
@endsection
