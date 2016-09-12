@extends('layouts.app')

@section('content')
<div class="">
  <div class="col-sm-12">
    <div class="alert alert-info" role="alert">
      供應商資訊 / Supplier
      <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
      新增 / Add New Supplier
    </div>
    <div class="btn-group btn-group-justified">
      <a href="/supplier"><button type="button" class="btn btn-primary btn-raised">返回 / Back</button></a>
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
  <form class="form" action="{{ url('/supplier')}}" method="post" role="form">
    {!! csrf_field() !!}
    <div class="form-group">
      <label class="col-sm-1 control-label">供應商編號</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="supplier_id" placeholder="Supplier ID">
      </div>
      <label class="col-sm-1 control-label">名稱</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="supplier_name" placeholder="Name">
      </div>
      <label class="col-sm-1 control-label">簡稱</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="short_name" placeholder="Nick Name">
      </div>
      <label class="col-sm-1 control-label">負責人</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="owner" placeholder="Owner">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">電話</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="phone" placeholder="Phone">
      </div>
      <label class="col-sm-1 control-label">手機</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="cell_phone" placeholder="Cell Phone">
      </div>
      <label class="col-sm-1 control-label">傳真</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="fax" placeholder="Fax">
      </div>
      <label class="col-sm-1 control-label">電子郵件</label>
      <div class="col-sm-2">
        <input type="email" class="form-control" name="email" placeholder="email">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">郵遞區號</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="zip_code" placeholder="Zip Code">
      </div>
      <label class="col-sm-1 control-label">地址</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="address" placeholder="Address">
      </div>
      <label class="col-sm-1 control-label">備註</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="remark" placeholder="Remark">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6">
        <input type="submit" class="btn btn-success btn-raised" value="Submit"/>
      </div>
    </div>
  </form>
</div>

@endsection
