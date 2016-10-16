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
            <li role="presentation" class="active"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Invoices</a></li>
            <li role="presentation"><a href="#customer" aria-controls="customer" role="tab" data-toggle="tab">Customer</a></li>
            <li role="presentation"><a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab">Inventory</a></li>
            <li role="presentation"><a href="#supplier" aria-controls="supplier" role="tab" data-toggle="tab">Supplier</a></li>
            <li role="presentation"><a href="#annual" aria-controls="annual" role="tab" data-toggle="tab">Annual</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <!--Customer Informations-->
            <div role="tabpanel" class="tab-pane fade" id="customer">
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
            <!--supplier div ends here, annual reports start-->
            <div role="tabpanel" class="tab-pane fade" id="annual">
              <h2>Annual Reports</h2>
              <div class="form-group">
                <form class="" action="{{ url('/information/annual') }}" method="post">
                  {!! csrf_field() !!}
                  
                  <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
                </form>
              </div>
            </div>
            <!--annual report ends-->
            <div role="tabpanel" class="tab-pane fade in active" id="invoices">
              <h2>Invoices</h2>
              <div class="col-sm-12">
                <!--purchase records panel-->
                <div class="col-sm-4">
                  <div class="panel panel-default">
                    <div class="panel-heading"><strong>進貨資料 / Purchase Records</strong></div>
                    <div class="panel-body">
                      <form class="" action="{{ url('/information/invoices_purchase') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label for="select111" class="col-sm-12 control-label">供應商 <br> Supplier</label>
                          <div class="col-sm-12">
                            <select name="supplier_id" class="form-control">
                              <option value="0">--select--</option>
                              @forelse($supplier as $sup)
                              <option value="{{ $sup->id}}">{{{ $sup->supplier_name }}}</option>
                              @empty

                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="select111" class="col-sm-12 control-label">日期 <br> Date</label>
                          <label for="start_date" class="col-sm-2 control-label">起<br>From</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="pur_start_date" name="start_date" placeholder="From" required>
                          </div>
                          <label for="end_date" class="col-sm-2 control-label">迄<br>To</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="pur_end_date" name="end_date" placeholder="From" required>
                          </div>
                        </div>
                        <input type="submit" class="btn btn-success btn-raised" value="查詢 / Search">
                      </form>
                    </div>
                  </div>
                </div>
                <!--proforma invoice records panel-->
                <div class="col-sm-4">
                  <div class="panel panel-default">
                    <div class="panel-heading"><strong>報價資料 / Proforma Invoice Records</strong></div>
                    <div class="panel-body">
                      <form class="" action="{{ url('/information/invoices_proforma') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label for="select111" class="col-sm-12 control-label">客戶 <br> Customer</label>
                          <div class="col-sm-12">
                            <select name="customer_id" class="form-control">
                              <option>--select--</option>
                              @forelse($customer as $cus)
                              <option value="{{ $cus->id}}">{{{ $cus->eng_name }}}</option>
                              @empty

                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="select111" class="col-sm-12 control-label">日期 <br> Date</label>
                          <label for="start_date" class="col-sm-2 control-label">起<br>From</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="pro_start_date" name="start_date" placeholder="From" required>
                          </div>
                          <label for="end_date" class="col-sm-2 control-label">迄<br>To</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="pro_end_date" name="end_date" placeholder="To" required>
                          </div>
                        </div>
                        <input type="submit" class="btn btn-success btn-raised" value="查詢 / Search">
                      </form>
                    </div>
                  </div>
                </div>
                <!--commercial invoice records panel-->
                <div class="col-sm-4">
                  <div class="panel panel-default">
                    <div class="panel-heading"><strong>出貨資料 / Commercial Invoice Records</strong></div>
                    <div class="panel-body">
                      <form class="" action="{{ url('/information/invoices_commercial') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label for="select111" class="col-sm-12 control-label">客戶 <br> Customer</label>
                          <div class="col-sm-12">
                            <select name="supllier_id" class="form-control">
                              <option>--select--</option>
                              @forelse($customer as $cus)
                              <option value="{{ $cus->id}}">{{{ $cus->eng_name }}}</option>
                              @empty

                              @endforelse
                            </select>
                          </div>
                          <label for="select111" class="col-sm-12 control-label">日期 <br> Date</label>
                          <label for="start_date" class="col-sm-2 control-label">起<br>From</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="com_start_date" name="start_date" placeholder="From" required>
                          </div>
                          <label for="end_date" class="col-sm-2 control-label">迄<br>To</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="com_end_date" name="end_date" placeholder="To" required>
                          </div>
                        </div>
                        <input type="submit" class="btn btn-success btn-raised" value="查詢 / Search">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <script type="text/javascript">
                var now = new Date();
                var time_now = ("0" + now.getYear()).slice(-2) + ("0" + now.getMonth(now.setMonth(now.getMonth()+1))).slice(-2) + ("0" + now.getDate()).slice(-2);
                var date = new Date();
                var start_date = new Date();
                date.setHours(now.getDate() + 8 );
                start_date.setDate(1);
                start_date.setHours(start_date.getDate() + 8 );
                document.getElementById('pur_start_date').valueAsDate = start_date;
                document.getElementById('pur_end_date').valueAsDate = date;
                document.getElementById('pro_start_date').valueAsDate = start_date;
                document.getElementById('pro_end_date').valueAsDate = date;
                document.getElementById('com_start_date').valueAsDate = start_date;
                document.getElementById('com_end_date').valueAsDate = date;
              </script>
              <!--
              <form action="{{ url('/information/invoices') }}" method="post">
                {!! csrf_field() !!}
                <div class="col-sm-3">
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="invoice_type" value="purchase" checked="true">
                      Purchase Records
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="invoice_type" value="proforma">
                      Proforma Invoice Records
                    </label>
                  </div>
                  <div class="radio radio-primary">
                    <label>
                      <input type="radio" name="invoice_type" value="commercial">
                      Commercial Invoice Records
                    </label>
                  </div>
                </div>
                <div class="col-sm-9">
                  <div class="form-group">
                    <label for="start_date" class="col-md-2 control-label">From</label>
                    <div class="col-md-10">
                      <input type="date" class="form-control" id="start_date" name="start_date" placeholder="From" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="end_date" class="col-md-2 control-label">End</label>
                    <div class="col-md-10">
                      <input type="date" class="form-control" id="end_date" name="end_date" placeholder="From" required>
                    </div>
                  </div>
                  <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
                </div>
              </form>
            -->
            </div>

          </div>
        </div>
      </div>
    </div>
</div>
@endsection
