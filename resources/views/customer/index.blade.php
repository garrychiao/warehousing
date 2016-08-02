@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function copy(){
    var respond = document.getElementById("respond_person").value;
    document.getElementById("contact_person").value = respond;
  }
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          客戶資訊 / Customers
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/customer/create') }}"><button type="button" class="btn btn-primary btn-raised">新增 / create</button></a>
        </div>
      </div>
        <div class="col-sm-7">
            @if (count($lists) > 0)
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>客戶編號<br><small>Customer ID</small></th>
                  <th>公司名稱<br><small>Company Name</small></th>
                  <th>負責人<br><small>Owner</small></th>
                  <th>電話<br><small>Phone</small></th>
                  <th>操作<br><small>Actions</small></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($lists as $list)
                <tr>
                  <td>
                    <a>{{ $list->customer_id }}</a>
                  </td>
                  <td>
                    {{ $list->chi_name }}</br>
                    {{ $list->eng_name }}
                  </td>
                  <td>
                    {{ $list->owner }}
                  </td>
                  <td>
                    {{ $list->phone }}
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('customer.show', $list->id) }}'">Details</button>
                      <button type="button" class="btn btn-info dropdown-toggle btn-raised btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu">
                        <li align="center">
                          <form class="form-horizontal" action="{{ url('/customer/'.$list->id)}}" method="post" role="form">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="delete" />
                            <input type="submit" class="btn btn-danger" value="Delete">
                          </form>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif
        </div>
        <div class="col-sm-5">
          @if (count($show) > 0)
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">Basic Info</a></li>
            <li role="presentation"><a href="#consignee" aria-controls="consignee" role="tab" data-toggle="tab">Consignee & Notify Party</a></li>
          </ul>
          <form class="form-horizontal" action="{{ url('/customer/'.$show->id)}}" method="post" role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="put" />
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="basic">
                <div class="form-group">
                  <label class="col-sm-2 control-label">客戶編號</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="customer_id" value="{{ $show->customer_id }}">
                  </div>
                  <label class="col-sm-2 control-label">客戶簡稱</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="short_name" value="{{ $show->short_name }}">
                  </div>
                  <label class="col-sm-2 control-label">中文名稱</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="chi_name" value="{{ $show->chi_name }}">
                  </div>
                  <label class="col-sm-2 control-label">英文名稱</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="eng_name" value="{{ $show->eng_name }}">
                  </div>
                  <label class="col-sm-2 control-label">負責人</label>
                  <div class="col-sm-3">
                    <input type="text" id="respond_person" class="form-control" name="owner" value="{{ $show->owner }}">
                  </div>
                  <div class="col-sm-2">
                    <button type="button" onclick="copy();" class="btn btn-primary btn-raised btn-sm">Copy</button>
                  </div>
                  <label class="col-sm-2 control-label">聯絡人</label>
                  <div class="col-sm-3">
                    <input type="text" id="contact_person" class="form-control" name="contact_person" value="{{ $show->contact_person }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">電子郵件</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="{{ $show->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">FAX</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="fax" value="{{ $show->fax }}">
                  </div>
                  <label class="col-sm-2 control-label">電話號碼</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="phone" value="{{ $show->phone }}">
                  </div>
                  <label class="col-sm-2 control-label">手機號碼</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cell_phone" value="{{ $show->cell_phone }}">
                  </div>
                  <label class="col-sm-2 control-label">發票抬頭</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="invoice" value="{{ $show->invoice }}">
                  </div>
                  <label class="col-sm-2 control-label">支票抬頭</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="check" value="{{ $show->check }}">
                  </div>
                  <label class="col-sm-2 control-label">統一編號</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="EIN" value="{{ $show->EIN }}">
                  </div>
                  <label class="col-sm-2 control-label">國別</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="nationality" value="{{ $show->nationality }}">
                  </div>
                  <label class="col-sm-2 control-label">幣別</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="currency" value="{{ $show->currency }}">
                  </div>
                  <label class="col-sm-2 control-label">備註</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="remark" value="{{ $show->remark }}">
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="consignee">
                <div class="col-sm-12">
                  <div class="form-group">
                    <table class="table table-condensed table-bordered table-hover">
                      <tr class="info">
                        <th colspan="8">
                          Consignee Info
                        </th>
                      </tr>
                      <tr>
                        <td>公司名稱</td><td><input type="text" class="form-control" name="consignee_name" value="{{ $show->consignee_name }}"></td>
                      </tr>
                      <tr>
                        <td>聯絡人</td><td><input type="text" class="form-control" name="consignee_contact" value="{{ $show->consignee_contact }}"></td>
                      </tr>
                      <tr>
                        <td>電話</td><td><input type="text" class="form-control" name="consignee_phone" value="{{ $show->consignee_phone }}"></td>
                      </tr>
                      <tr>
                        <td>地址</td>
                        <!--<td><input type="text" class="form-control" name="consignee_address" ss"></td>-->
                        <td>
                          <input type="text" class="form-control" name="consignee_zip" value="{{ $show->consignee_zip }}">
                          <textarea name="consignee_address" type="text" rows="5" class="form-control">{{ $show->consignee_address }}</textarea>
                        </td>
                      </tr>
                      <tr class="info">
                        <th colspan="8">
                          Notify Party Info
                        </th>
                      </tr>
                      <tr>
                        <td>公司名稱</td><td><input type="text" class="form-control" name="notify_name" value="{{ $show->notify_name }}"></td>
                      </tr>
                      <tr>
                        <td>聯絡人</td><td><input type="text" class="form-control" name="notify_contact" value="{{ $show->notify_contact }}"></td>
                      </tr>
                      <tr>
                        <td>電話</td><td><input type="text" class="form-control" name="notify_phone" value="{{ $show->notify_phone }}"></td>
                      </tr>
                      <tr>
                        <td>
                          地址
                        </td>
                        <td>
                          <input type="text" class="form-control" name="notify_zip" value="{{ $show->notify_zip }}">
                          <textarea name="notify_address" type="text" rows="5" class="form-control">{{ $show->notify_address }}</textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
          </form>
          @endif
        </div>
    </div>
</div>
@endsection
