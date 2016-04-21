@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          供應商資訊 / Supplier
        </div>
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="/supplier/create"><button type="button" class="btn btn-primary btn-raised">新增 / create</button></a>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">

      </div>
      <div class="col-md-7 col-sm-7">
          @if (count($lists) > 0)
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>供應商編號<br><small>Supplier ID</small></th>
                <th>名稱<br><small>Name</small></th>
                <th>負責人<br><small>Owner</small></th>
                <th>操作<br><small>Actions</small></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($lists as $list)
              <tr>
                <td>
                  <a>{{ $list->supplier_id }}</a>
                </td>
                <td>
                  {{ $list->supplier_name }}
                </td>
                <td>
                  {{ $list->owner }}
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" target="center" class="btn btn-info btn-raised" onclick="window.location.href='{{ URL::route('supplier.show', $list->id) }}'">Details</button>
                    <button type="button" class="btn btn-info dropdown-toggle btn-raised" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li align="center">
                        <form class="form-horizontal" action="{{ url('/supplier/'.$list->id)}}" method="post" role="form">
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
        @if( count ( $show ) > 0 )
        <form class="form-horizontal" action="{{ url('/supplier/'.$show->id)}}" method="post" role="form">
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="put" />
          <div class="form-group">
            <label class="col-sm-2 control-label">編號</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="supplier_id" value="{{ $show->supplier_id }}">
            </div>
            <label class="col-sm-2 control-label">名稱</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="supplier_name" value="{{ $show->supplier_name }}">
            </div>
            <label class="col-sm-2 control-label">簡稱</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="short_name" value="{{ $show->short_name }}">
            </div>
            <label class="col-sm-2 control-label">負責人</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="owner" value="{{ $show->owner }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">電話</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="phone" value="{{ $show->phone }}">
            </div>
            <label class="col-sm-2 control-label">手機</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="cell_phone" value="{{ $show->cell_phone }}">
            </div>
            <label class="col-sm-2 control-label">傳真</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="fax" value="{{ $show->fax }}">
            </div>
            <label class="col-sm-2 control-label">電子郵件</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="email" value="{{ $show->email }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">地址</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="zip_code" value="{{ $show->zip_code }}">
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="address" value="{{ $show->address }}">
            </div>
            <label class="col-sm-2 control-label">備註</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="remark" value="{{ $show->remark }}">
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
