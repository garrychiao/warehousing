@extends('layouts.app')

@section('content')
<div class="">
  <div class="col-sm-12">
    <div class="alert alert-success" role="alert">
      客戶資訊 / Customers
      <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
      新增 / Add New Customer
    </div>
    <div class="btn-group btn-group-justified">
      <a href="/customer"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
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
        <input type="text" class="form-control" name="short_name" placeholder="nickname">
      </div>
      <label class="col-sm-1 control-label">姓名</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="chi_name" placeholder="中文姓名">
      </div>
      <label class="col-sm-1 control-label">英文名稱</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="eng_name" placeholder="English Name">
      </div>
      <label class="col-sm-1 control-label">負責人</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="owner" placeholder="Owner">
      </div>
      <label class="col-sm-1 control-label">聯絡人</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="contact_person" placeholder="Contact Person">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">公司名稱</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="company_name" placeholder="Company Name">
      </div>
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
        <input type="text" class="form-control" name="phone" placeholder="Phone Number">
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
    <div class="form-group">
      <label class="col-sm-1 control-label">聯絡地址</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="contact_zip_code" placeholder="Zip Code">
      </div>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="contact_address" placeholder="Address">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">收件地址</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="recieve_zip_code" placeholder="Zip Code">
      </div>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="recieve_address" placeholder="Address">
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
