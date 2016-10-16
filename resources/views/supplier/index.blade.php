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
                    <a href="#{{ $list->id }}" aria-controls="" class="btn btn-sm btn-raised btn-info" role="tab" data-toggle="tab">Details</a>
                    <button type="button" class="btn btn-info dropdown-toggle btn-sm btn-raised" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li align="center">
                        <form class="form-horizontal" action="{{ url('/supplier/'.$list->id)}}" method="post" role="form">
                          {!! csrf_field() !!}
                          <input type="hidden" name="_method" value="delete" />
                          <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $lists->links() }}
          @endif
      </div>
      <div class="col-sm-5">
        <div class="tab-content">
          @foreach($lists as $key=>$list)
            <div role="tabpanel" class="tab-pane fade in @if($key==0) active @endif" id="{{ $list->id}}">
              <form class="form-horizontal" action="{{ url('/supplier/'.$list->id)}}" method="post" role="form">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="put" />
                <div class="form-group">
                  <table class="table table-bordered table-condensed">
                    <tr>
                      <th>名稱<br>Name</th>
                      <td colspan="3"><input type="text" class="form-control" name="supplier_name" value="{{ $list->supplier_name }}"></td>
                    </tr>
                    <tr>
                      <th>編號<br>ID</th><td><input type="text" class="form-control" name="supplier_id" value="{{ $list->supplier_id }}"></td>
                      <th>簡稱<br>Short Name</th><td><input type="text" class="form-control" name="short_name" value="{{ $list->short_name }}"></td>
                    </tr>
                    <tr>
                      <th>負責人<br>Owner</th><td><input type="text" class="form-control" name="owner" value="{{ $list->owner }}"></td>
                      <th>電話<br>Phone</th><td><input type="text" class="form-control" name="phone" value="{{ $list->phone }}"></td>
                    </tr>
                    <tr>
                      <th>手機<br>Cell Phone</th><td><input type="text" class="form-control" name="cell_phone" value="{{ $list->cell_phone }}"></td>
                      <th>傳真<br>Fax</th><td><input type="text" class="form-control" name="fax" value="{{ $list->fax }}"></td>
                    </tr>
                    <tr>
                      <th>電子郵件<br>Email</th>
                      <td colspan="3"><input type="email" class="form-control" name="email" value="{{ $list->email }}"></td>
                    </tr>
                    <tr>
                      <th>地址<br>Address</th>
                      <td colspan="3">
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" value="{{ $list->zip_code }}">
                        </div>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="address" placeholder="Address" value="{{ $list->address }}">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>備註<br>Remarks</th>
                      <td colspan="3">
                        <input type="text" class="form-control" name="remark" value="{{ $list->remark }}">
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
                  </div>
                </div>
              </form>
            </div>
          @endforeach
        </div>
      </div>
    </div>
</div>
@endsection
