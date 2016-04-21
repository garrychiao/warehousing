@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
          <div class="hidden-print">
            <div class="alert alert-success" role="alert">
              出貨單 / Commercial Invoice
              <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
              出貨紀錄 / Commercial Invoice Records
              <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
              {{$records->order_id}}
            </div>
            <div class="btn-group btn-group-justified">
              <a href="/shippment/commercial/create"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
              <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
            </div>
          </div>

          <table class="table table-condensed table-bordered table-hover">
            <tr class="visible-print"><th colspan="8">Proforma Invoice</th></tr>
            <tr>
              <td colspan="2" align="center">
                @if(count($mycompany_img)>0)
                  <img src="../../{{ $mycompany_img->img_url }}" alt="" width="120px" />
                @endif
              </td>
              <td colspan="4" class="col-sm-7">
                <h4>{{$mycompany->eng_name}}</h4>{{$mycompany->eng_address}}<br>
                {{$mycompany->email}}<br>Tel. +886{{$mycompany->phone}} +886{{$mycompany->cell_phone}}
              </td>
              <td colspan="2" class="col-sm-3">
                <h4>Commercial Invoice</h4>
                <small>Date : {{$records->create_date}}<br>
                Invoice# : {{$records->order_id}}</small>
              </td>
            </tr>
            <tr class="success">
              <th colspan="4" class="col-sm-6">Consignee</th>
              <th colspan="4" class="col-sm-6">Shipper / Exporter</th>
            </tr>
            <tr>
              <!--make newline character working -->
              <td colspan="4">{!!nl2br(e($records->exporter))!!}</td>
              <td colspan="4">{!!nl2br(e($records->consignee))!!}</td>
            </tr>
            <tr class="success">
              <th colspan="4">Notify Party</th>
              <th colspan="2">Date of Export</th>
              <th colspan="2">Reference</th>
            </tr>
            <tr>
              <!--make newline character working -->
              <td colspan="4" rowspan="3">{!!nl2br(e($records->notify_party))!!}</td>
              <td colspan="2">{{ $records->export_date }}</td>
              <td colspan="2">{{ $records->reference }}</td>
            </tr>
            <tr class="success">
              <th colspan="2">Currency</th>
              <th colspan="2">Terms of Sales</th>
            </tr>
            <tr>
              <td colspan="2">{{ $records->currency }}</td>
              <td colspan="2">{{ $records->terms_of_sale }}</td>
            </tr>
            <tr class="success">
              <th>Item Code</th><th colspan="3">Description</th><th>Weight (kg)</th><th>Quantity</th><th>Price Each</th><th>Amount</th>
            </tr>
            @if(count($inventory)>0)
              @foreach($inventory as $inv)
                <tr>
                  <td>{{$inv->item_id}}</td>
                  <td colspan="3">{{$inv->descriptions}}</td>
                  <td>{{$inv->weight}}</td>
                  <td>{{$inv->quantity}}</td>
                  <td>{{number_format($inv->unit_price,2)}}</td>
                  <td align="right">{{number_format($inv->total,2)}}</td>
                </tr>
              @endforeach
              <tr class="success">
                <td colspan="4" align="right"><strong>Sub-Total : </strong></td>
                <td align="right">{{number_format($total->weight)}}</td>
                <td align="right">{{number_format($total->quantity)}}</td>
                <td align="right">{{number_format($total->unit_price,2)}}</td>
                <td align="right">{{number_format($total->total,2)}}</td>
              </tr>
              <tr>
                <td colspan="6" align="right"><strong>Shipping : </strong></td>
                <td colspan="2" align="right">{{number_format($records->cost_shipping,2)}}</td>
              </tr>
              <tr>
                <td colspan="6" align="right"><strong>Insurance Costs : </strong></td>
                <td colspan="2" align="right">{{number_format($records->cost_insurance,2)}}</td>
              </tr>
              <tr>
                <td colspan="6" align="right"><strong>Additional Costs : </strong></td>
                <td colspan="2" align="right">{{number_format($records->cost_additional,2)}}</td>
              </tr>
              <tr>
                <td colspan="6" align="right"><h4>Total Costs : </h4></td>
                <td colspan="2" align="right"><h4>{{number_format($final_total,2)}}</h4></td>
              </tr>
            @endif
            <tr class="success">
              <th colspan="2">Phone#</th>
              <th colspan="2">E-mail</th>
              <th colspan="2">Fax#</th>
              <th colspan="2">Web Site</th>
            </tr>
            <tr>
              <td colspan="2">{{$mycompany->phone}}</td>
              <td colspan="2">{{$mycompany->email}}</td>
              <td colspan="2">{{$mycompany->fax}}</td>
              <td colspan="2">{{$mycompany->website}}</td>
            </tr>
          </table>
        </div>
    </div>
</div>
@endsection
