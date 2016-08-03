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
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/information')}}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
          <a><button type="button" class="btn btn-primary btn-raised" onclick="print()">列印 / Print</button></a>
        </div>
        <div class="col-sm-12">
          <table class="table table-condensed table-bordered">
            <tr>
              <td colspan="2" align="center">
                <h2>{{$mycompany->eng_name}}</h2>
              </td>
            </tr>
            <tr align="center">
              <td>
                @if($type == "customer")
                <h4>Customer Informations</h4>
                @elseif($type == "inventory")
                <h4>Product Informations</h4>
                @elseif($type == "supplier")
                <h4>Supplier Informations</h4>
                @endif
              </td>
              <td>
                {{$mycompany->eng_address}}
                {{$mycompany->email}}<br>Tel. +886{{$mycompany->phone}} +886{{$mycompany->cell_phone}}
              </td>
            </tr>
          </table>
          <table class="table table-condensed table-bordered table-hover">
          @if( $type == "customer")
            <tr>
              <td>ID</td>
              <td>中文名稱</td>
              <td>英文名稱</td>
              <td>負責人</td>
              <td>聯絡人</td>
              <td>電話</td>
            </tr>
            @forelse($information as $cus)
            <tr>
              <td><p>{{ $cus->customer_id}}</p></td>
              <td><p>{{ $cus->chi_name}}</p></td>
              <td><p>{{ $cus->eng_name}}</p></td>
              <td><p>{{ $cus->owner}}</p></td>
              <td><p>{{ $cus->contact_person}}</p></td>
              <td><p>{{ $cus->phone}}</p></td>
            </tr>
            @empty
            <tr>
              <td>無資料</td>
              <td>無資料</td>
              <td>無資料</td>
              <td>無資料</td>
              <td>無資料</td>
              <td>無資料</td>
            </tr>
            @endforelse
          @elseif($type == "inventory")
          <tr>
            <td>ID</td>
            <td>名稱</td>
            <td>內容</td>
            <td>重量(per)</td>
            <td>價格1</td>
            <td>價格2</td>
            <td>價格3</td>
            <td>價格4</td>
            <td>價格5</td>
            <td>價格6</td>
          </tr>
          @forelse($information as $inv)
          <tr>
            <td><p>{{ $inv->item_id}}</p></td>
            <td><p>{{ $inv->item_name}}</p></td>
            <td><p>{{ $inv->descriptions}}</p></td>
            <td><p>{{ $inv->unit_weight}}</p></td>
            <td><p>{{ $inv->price1}}</p></td>
            <td><p>{{ $inv->price2}}</p></td>
            <td><p>{{ $inv->price3}}</p></td>
            <td><p>{{ $inv->price4}}</p></td>
            <td><p>{{ $inv->price5}}</p></td>
            <td><p>{{ $inv->price6}}</p></td>
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
            <td>無資料</td>
            <td>無資料</td>
            <td>無資料</td>
          </tr>
          @endforelse
          @elseif($type == "supplier")
          <tr>
            <td>ID</td>
            <td>名稱</td>
            <td>電話</td>
            <td>傳真</td>
            <td>電子郵件</td>
            <td>地址</td>
          </tr>
          @forelse($information as $sup)
          <tr>
            <td>{{ $sup->supplier_id}}</td>
            <td>{{ $sup->supplier_name}}</td>
            <td>{{ $sup->phone}}</td>
            <td>{{ $sup->fax}}</td>
            <td>{{ $sup->email}}</td>
            <td>{{ $sup->address}}</td>
          </tr>
          @empty
          <tr>
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
