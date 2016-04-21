@extends('layouts.app')

@section('content')
<div class="col-md-12">
  @if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  <form class="form-horizontal" action="{{ url('/customer/'.$customer->id)}}" method="post" role="form">
    {!! csrf_field() !!}
    <input type="hidden" name="_method" value="put" />
    <div class="form-group">
      <label class="col-sm-1 control-label">姓名</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="chi_name" value="{{ $customer->chi_name }}">
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="eng_name" value="{{ $customer->eng_name }}">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">電子郵件</label>
      <div class="col-sm-8">
        <input type="email" class="form-control" name="email" value="{{ $customer->email }}">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">統一編號</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="EIN" value="{{ $customer->EIN }}">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">電話號碼</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}">
      </div>
      <label class="col-sm-1 control-label">手機號碼</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="cell_phone" value="{{ $customer->cell_phone }}">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">聯絡地址</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="contact_zip_code" value="{{ $customer->contact_zip_code }}">
      </div>
      <div class="col-sm-7">
        <input type="text" class="form-control" name="contact_address" value="{{ $customer->contact_address }}">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-1 control-label">收件地址</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" name="recieve_zip_code" value="{{ $customer->recieve_zip_code }}">
      </div>
      <div class="col-sm-7">
        <input type="text" class="form-control" name="recieve_address" value="{{ $customer->recieve_address }}">
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
