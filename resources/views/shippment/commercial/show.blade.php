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
              <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
              <a href="{{ url('/shippment/commercial/create') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
              <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
              <a href="{{ url('/excel/commercial/'.$records->id) }}"><button type="button" class="btn btn-primary btn-raised">Excel</button></a>
            </div>
          </div>

          <table class="table table-condensed table-bordered table-hover hidden-print">
            <tr>
              <td colspan="8" class="col-sm-10" align="center">
                <h2>{{$mycompany->eng_name}}</h2>{{$mycompany->eng_address}}<br>
                {{$mycompany->email}}<br>Tel. {{$mycompany->phone}}{{$mycompany->cell_phone}}
                <h3>Commercial Invoice</h3>
              </td>
            </tr>
            <tr>
              <td colspan="8" align="right">Date : {{ $records->create_date }}</td>
            </tr>
            <tr class="success">
              <th colspan="2" class="col-sm-2">Date of Export</th>
              <th colspan="2" class="col-sm-2">Terms of sale</th>
              <th colspan="2" class="col-sm-2">Reference</th>
              <th colspan="2" class="col-sm-2">Currency</th>
            </tr>
            <tr>
              <td colspan="2">{{ $records->export_date}}</td>
              <td colspan="2">{{ $records->terms_of_sale }}</td>
              <td colspan="2">{{ $records->reference }}</td>
              <td colspan="2">{{ $records->currency }}</td>
            </tr>
            <tr class="success">
              <th colspan="4"> Shipper/Exporter :</th>
              <th colspan="4">Consignee : </th>
            </tr>
            <tr>
              <td colspan="4">{!!nl2br(e($records->exporter))!!}</td>
              <td colspan="4">{!!nl2br(e($records->consignee))!!}</td>
            </tr>
            <tr class="success">
              <th colspan="4">Country of Ultimate Destination</th>
              <th colspan="4">Notify Party :</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->destination_country}}</td>
              <td colspan="4" rowspan="5">{!!nl2br(e($records->notify_party))!!}</td>
            </tr>
            <tr class="success">
              <th colspan="4" class="col-sm-2">Country Of Manufacture</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->manufacture_country}}</td>
            </tr>
            <tr class="success">
              <th colspan="4" class="col-sm-2">International Airwaybill Number</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->airwaybill_number}}</td>
            </tr>
            <tr class="success">
              <th>Item Code</th><th colspan="3">Item Name</th><th>Weight (kg)</th><th>Quantity</th><th>Price Each</th><th>Amount</th>
            </tr>
            @if(count($inventory_kits_records)>0)
              @foreach($inventory_kits_records as $kit)
              <tr>
                <td>{{$kit->item_id}}</td>
                <td colspan="3">{{$kit->kits_name}}</td>
                <td>{{number_format($kit->weight,2)}}</td>
                <td>{{number_format($kit->quantity,0)}}</td>
                <td>{{number_format($kit->unit_price,2)}}</td>
                <td align="right">{{number_format($kit->total,2)}}</td>
              </tr>
              @endforeach
            @endif
            @if(count($inventory)>0)
              @foreach($inventory as $inv)
                <tr>
                  <td>{{$inv->item_id}}</td>
                  <td colspan="3">{{$inv->item_name}}</td>
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
                <td colspan="6" align="right"><h4>Total Incoive Value : </h4></td>
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

          <table class="visible-print-block">
            <tr>
              <td colspan="8" align="center">
                <h3>{{$mycompany->eng_name}}</h3>{{$mycompany->eng_address}}<br>
                {{$mycompany->email}}<br>Tel. {{$mycompany->phone}} +886{{$mycompany->cell_phone}}
                <h4>Commercial Invoice</h4>
              </td>
            </tr>
            <tr>
              <td colspan="8" align="right">Date : {{ $records->create_date }}</td>
            </tr>
            <tr class="success">
              <th colspan="2">Date of Export</th>
              <th colspan="2">Terms of sale</th>
              <th colspan="2">Reference</th>
              <th colspan="2">Currency</th>
            </tr>
            <tr>
              <td colspan="2">{{ $records->export_date}}</td>
              <td colspan="2">{{ $records->terms_of_sale }}</td>
              <td colspan="2">{{ $records->reference }}</td>
              <td colspan="2">{{ $records->currency }}</td>
            </tr>
            <tr class="success">
              <th colspan="4"> Shipper/Exporter :</th>
              <th colspan="4">Consignee : </th>
            </tr>
            <tr>
              <td colspan="4">{!!nl2br(e($records->exporter))!!}</td>
              <td colspan="4">{!!nl2br(e($records->consignee))!!}</td>
            </tr>
            <tr class="success">
              <th colspan="4">Country of Ultimate Destination</th>
              <th colspan="4">Notify Party :</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->destination_country}}</td>
              <td colspan="4" rowspan="5">{!!nl2br(e($records->notify_party))!!}</td>
            </tr>
            <tr class="success">
              <th colspan="4">Country Of Manufacture</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->manufacture_country}}</td>
            </tr>
            <tr class="success">
              <th colspan="4">International Airwaybill Number</th>
            </tr>
            <tr>
              <td colspan="4">{{ $records->airwaybill_number}}</td>
            </tr>
            <tr class="success">
              <!--<th>Item Code</th>--><th colspan="4">Description</th><th>Weight (kg)</th><th>Quantity</th><th>Price Each</th><th>Amount</th>
            </tr>
            @if(count($inventory_kits_records)>0)
              @foreach($inventory_kits_records as $kit)
              <tr>
                <td>{{$kit->item_id}}</td>
                <td colspan="3">{{$kit->kits_name}}</td>
                <td>{{number_format($kit->weight,2)}}</td>
                <td>{{number_format($kit->quantity,0)}}</td>
                <td>{{number_format($kit->unit_price,2)}}</td>
                <td align="right">{{number_format($kit->total,2)}}</td>
              </tr>
              @endforeach
            @endif
            @if(count($inventory)>0)
              @foreach($inventory as $inv)
                <tr>
                  <td>{{$inv->item_id}}</td>
                  <td colspan="3">{{$inv->item_name}}</td>
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
                <td colspan="6" align="right"><h5>Total Invoice Value : </h5></td>
                <td colspan="2" align="right"><h5>{{number_format($final_total,2)}}</h5></td>
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
            <tr>
              <td colspan="8">
                <div class="col-sm-10 col-sm-offset-1">
                  <p>
                    I hearby certify that this invoice shows the actual price of goods described, that no other invoice has been issued, and that all particulars are true and correct.
                  </p>
                </div>
                <div class="col-sm-6">
                  <p class="label">Signature of shipper / exporter</p>
                  <br><br><br>
                  <div class="col-sm-6 col-sm-offset-2">
                    <p>
                      __________________________________________________
                    </p>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
    </div>
</div>
@endsection
