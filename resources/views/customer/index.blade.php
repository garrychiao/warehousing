@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          客戶資訊 / Customers
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/customer/create"><button type="button" class="btn btn-primary btn-raised">新增 / create</button></a>
        </div>
      </div>
        <div class="col-md-7 col-sm-7">
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
                    {{ $list->company_name }}
                  </td>
                  <td>
                    {{ $list->owner }}
                  </td>
                  <td>
                    {{ $list->phone }}
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" target="center" class="btn btn-info btn-raised" onclick="window.location.href='{{ URL::route('customer.show', $list->id) }}'">Details</button>
                      <button type="button" class="btn btn-info dropdown-toggle btn-raised" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <form class="form-horizontal" action="{{ url('/customer/'.$show->id)}}" method="post" role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="put" />
            <div class="form-group">
              <label class="col-sm-2 control-label">客戶編號</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="customer_id" value="{{ $show->customer_id }}">
              </div>
              <label class="col-sm-2 control-label">客戶簡稱</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="short_name" value="{{ $show->short_name }}">
              </div>
              <label class="col-sm-2 control-label">姓名</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="chi_name" value="{{ $show->chi_name }}">
              </div>
              <label class="col-sm-2 control-label">英文名稱</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="eng_name" value="{{ $show->eng_name }}">
              </div>
              <label class="col-sm-2 control-label">負責人</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="owner" value="{{ $show->owner }}">
              </div>
              <label class="col-sm-2 control-label">聯絡人</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="contact_person" value="{{ $show->contact_person }}">
              </div>
              <label class="col-sm-2 control-label">公司名稱</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="company_name" value="{{ $show->company_name }}">
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
            <div class="form-group">
              <label class="col-sm-2 control-label">聯絡地址</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="contact_zip_code" value="{{ $show->contact_zip_code }}">
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="contact_address" value="{{ $show->contact_address }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">收件地址</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="recieve_zip_code" value="{{ $show->recieve_zip_code }}">
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="recieve_address" value="{{ $show->recieve_address }}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
              </div>
            </div>
          </form>
          @endif
        </div>
    </div>
</div>
@endsection
