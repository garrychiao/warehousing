@extends('layouts.app')

@section('content')
<script type="text/javascript">
function check_all(obj,cName)
{
  var checkboxs = document.getElementsByName(cName);
  for(var i=0;i<checkboxs.length;i++){
    checkboxs[i].checked = obj.checked;
  }
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          資料輸出 / Data Export
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
        </div>
        <div class="col-sm-12">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#customer" aria-controls="customer" role="tab" data-toggle="tab">Customer</a></li>
            <li role="presentation"><a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab">Inventory</a></li>
            <li role="presentation"><a href="#supplier" aria-controls="supplier" role="tab" data-toggle="tab">Supplier</a></li>
            <li role="presentation"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Invoices</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <!--Customer Informations-->
            <div role="tabpanel" class="tab-pane fade in active" id="customer">
              <h2>Customer Informations</h2>
              <div class="form-group">
                <form class="" action="{{ url('/information/customer') }}" method="post">
                  {!! csrf_field() !!}
                  <table class="table table-condensed table-bordered table-hover">
                    <tr>
                      <td>
                        <input type="checkbox" onclick="check_all(this,'customer[]')"> 全選
                      </td>
                      <td>ID</td>
                      <td>中文名稱</td>
                      <td>英文名稱</td>
                      <td>負責人</td>
                      <td>聯絡人</td>
                      <td>電話</td>
                    </tr>
                    @forelse($customer as $cus)
                    <tr>
                      <td>
                        <input type="checkbox" name="customer[]" value="{{ $cus->id}}">
                      </td>
                      <td>{{ $cus->customer_id}}</td>
                      <td>{{ $cus->chi_name}}</td>
                      <td>{{ $cus->eng_name}}</td>
                      <td>{{ $cus->owner}}</td>
                      <td>{{ $cus->contact_person}}</td>
                      <td>{{ $cus->phone}}</td>
                    </tr>
                    @empty
                    <tr>
                      <td></td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                    </tr>
                    @endforelse
                  </table>
                  <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
                </form>
              </div>
            </div>
            <!--Inventory Informations-->
            <div role="tabpanel" class="tab-pane fade" id="inventory">
              <h2>Inventory Informations</h2>
              <div class="form-group">
                <form class="" action="{{ url('/information/inventory') }}" method="post">
                  {!! csrf_field() !!}
                  <table class="table table-condensed table-bordered table-hover">
                    <tr>
                      <td>
                        <input type="checkbox" onclick="check_all(this,'inventory[]')"> 全選
                      </td>
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
                    @forelse($inventory as $inv)
                    <tr>
                      <td>
                        <input type="checkbox" name="inventory[]" value="{{ $inv->id}}">
                      </td>
                      <td>{{ $inv->item_id}}</td>
                      <td>{{ $inv->item_name}}</td>
                      <td>{{ $inv->descriptions}}</td>
                      <td>{{ $inv->unit_weight}}</td>
                      <td>{{ $inv->price1}}</td>
                      <td>{{ $inv->price2}}</td>
                      <td>{{ $inv->price3}}</td>
                      <td>{{ $inv->price4}}</td>
                      <td>{{ $inv->price5}}</td>
                      <td>{{ $inv->price6}}</td>
                    </tr>
                    @empty
                    <tr>
                      <td></td>
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
                  </table>
                  <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
                </form>
              </div>
            </div>
            <!--Supplier Informations-->
            <div role="tabpanel" class="tab-pane fade" id="supplier">
              <h2>Inventory Informations</h2>
              <div class="form-group">
                <form class="" action="{{ url('/information/supplier') }}" method="post">
                  {!! csrf_field() !!}
                  <table class="table table-condensed table-bordered table-hover">
                    <tr>
                      <td>
                        <input type="checkbox" onclick="check_all(this,'supplier[]')"> 全選
                      </td>
                      <td>ID</td>
                      <td>名稱</td>
                      <td>電話</td>
                      <td>傳真</td>
                      <td>電子郵件</td>
                      <td>地址</td>
                    </tr>
                    @forelse($supplier as $sup)
                    <tr>
                      <td>
                        <input type="checkbox" name="supplier[]" value="{{ $sup->id}}">
                      </td>
                      <td>{{ $sup->supplier_id}}</td>
                      <td>{{ $sup->supplier_name}}</td>
                      <td>{{ $sup->phone}}</td>
                      <td>{{ $sup->fax}}</td>
                      <td>{{ $sup->email}}</td>
                      <td>{{ $sup->address}}</td>
                    </tr>
                    @empty
                    <tr>
                      <td></td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                      <td>無資料</td>
                    </tr>
                    @endforelse
                  </table>
                  <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
                </form>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="invoices">Invoices</div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
