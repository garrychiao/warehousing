@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function copy_info(){
    document.getElementById("consignee_name").value = document.getElementById("basic_name").value;
    document.getElementById("notify_name").value = document.getElementById("basic_name").value;
    document.getElementById("consignee_phone").value = document.getElementById("basic_phone").value;
    document.getElementById("notify_phone").value = document.getElementById("basic_phone").value;
    document.getElementById("consignee_contact").value = document.getElementById("basic_contact").value;
    document.getElementById("notify_contact").value = document.getElementById("basic_contact").value;
  }
  function copy_address(){
    document.getElementById("consignee_zip").value = document.getElementById("notify_zip").value;
    document.getElementById("consignee_address").value = document.getElementById("notify_address").value;

  }
</script>
<div class="">
  <div class="col-sm-12">
    <div class="alert alert-success" role="alert">
      客戶資訊 / Customers
      <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
      新增 / Add New Customer
    </div>
    <div class="btn-group btn-group-justified">
      <a href="{{ url('/customer') }}"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
    </div>
  </div>
</div>
<div class="col-sm-12">
  @if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  <form class="form" action="{{ url('/customer')}}" method="post" role="form">
    {!! csrf_field() !!}
    <div class="form-group">
      <label class="col-sm-1 control-label">客戶編號</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="customer_id" placeholder="ID">
      </div>
      <label class="col-sm-1 control-label">客戶簡稱</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="short_name" placeholder="Abbreviation">
      </div>
      <label class="col-sm-1 control-label">中文名稱</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="chi_name" placeholder="中文名稱">
      </div>
      <label class="col-sm-1 control-label">英文名稱</label>
      <div class="col-sm-3">
        <input type="text" id="basic_name" class="form-control" name="eng_name" placeholder="English Name">
      </div>
      <label class="col-sm-1 control-label">負責人</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="owner" placeholder="Owner">
      </div>
      <label class="col-sm-1 control-label">聯絡人</label>
      <div class="col-sm-3">
        <input type="text" id="basic_contact" class="form-control" name="contact_person" placeholder="Contact Person">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">電子郵件</label>
      <div class="col-sm-7">
        <input type="email" class="form-control" name="email" placeholder="E-Mail">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">FAX</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="fax" placeholder="FAX">
      </div>
      <label class="col-sm-1 control-label">電話號碼</label>
      <div class="col-sm-3">
        <input type="text" id="basic_phone" class="form-control" name="phone" placeholder="Phone Number">
      </div>
      <label class="col-sm-1 control-label">手機號碼</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="cell_phone" placeholder="Cell Phone Number">
      </div>
      <label class="col-sm-1 control-label">發票抬頭</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="invoice" placeholder="Invoice">
      </div>
      <label class="col-sm-1 control-label">支票抬頭</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="check" placeholder="Check">
      </div>
      <label class="col-sm-1 control-label">統一編號</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="EIN" placeholder="EIN">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">國別</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="nationality" placeholder="Nationality">
      </div>
      <label class="col-sm-1 control-label">幣別</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="currency" placeholder="Currency">
      </div>
      <label class="col-sm-1 control-label">備註</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="remark" placeholder="Remark">
      </div>
    </div>
    <div class="col-sm-12">
      <button type="button" class="btn btn-default" onclick="copy_info();">資料同上 / Same as Above</button>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <table class="table table-condensed table-bordered table-hover">
          <tr class="info">
            <th colspan="8">
              Notify Party Info
            </th>
          </tr>
          <tr>
            <td>公司名稱</td><td><input id="notify_name" type="text" class="form-control" name="notify_name" placeholder="Name"></td>
          </tr>
          <tr>
            <td>聯絡人</td><td><input id="notify_contact" type="text" class="form-control" name="notify_contact" placeholder="Contact Person"></td>
          </tr>
          <tr>
            <td>電話</td><td><input id="notify_phone" type="text" class="form-control" name="notify_phone" placeholder="Phone"></td>
          </tr>
          <tr>
            <td>
              地址
            </td>
            <td>
              <input type="text" id="notify_zip" class="form-control" name="notify_zip" placeholder="Zip Code">
              <textarea id="notify_address" name="notify_address" type="text" rows="5" class="form-control" placeholder="Address"></textarea>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <!--<label class="col-sm-1 control-label">聯絡地址</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" name="contact_zip_code" placeholder="Zip Code">
        </div>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="contact_address" placeholder="Address">
        </div>-->
        <table class="table table-condensed table-bordered table-hover">
          <tr class="info">
            <th colspan="8">
              Consignee Info
            </th>
          </tr>
          <tr>
            <td>公司名稱</td><td><input id="consignee_name" type="text" class="form-control" name="consignee_name" placeholder="Name"></td>
          </tr>
          <tr>
            <td>聯絡人</td><td><input id="consignee_contact" type="text" class="form-control" name="consignee_contact" placeholder="Contact Person"></td>
          </tr>
          <tr>
            <td>電話</td><td><input id="consignee_phone" type="text" class="form-control" name="consignee_phone" placeholder="Phone"></td>
          </tr>
          <tr>
            <td>
              地址<br>
              <button type="button" class="btn btn-default btn-sm" onclick="copy_address();">複製地址 / Copy Address</button>
            </td>
            <!--<td><input type="text" class="form-control" name="consignee_address" placeholder="Address"></td>-->
            <td>
              <!--<input type="text" id="consignee_zip" class="form-control" name="consignee_zip" placeholder="Zip Code">-->
              <textarea name="consignee_address" id="consignee_address" type="text" rows="5" class="form-control" placeholder="Address"></textarea>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6">
        <input type="submit" class="btn btn-success btn-raised" value="確認送出 / Submit"/>
      </div>
    </div>
  </form>
</div>

@endsection
