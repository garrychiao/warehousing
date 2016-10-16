@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function copy(){
    var respond = document.getElementById("respond_person").value;
    document.getElementById("contact_person").value = respond;
  }
  function copy_shipping_info(){
    document.getElementById("consignee_name").value = document.getElementById("notify_name").value;
    document.getElementById("consignee_contact").value = document.getElementById("notify_contact").value;
    document.getElementById("consignee_phone").value = document.getElementById("notify_phone").value;
    //document.getElementById("consignee_zip").value = document.getElementById("notify_zip").value;
    document.getElementById("consignee_address").value = document.getElementById("notify_address").value;
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
                      <!--<button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('customer.show', $list->id) }}'">Details</button>-->
                      <a href="#{{ $list->id }}" aria-controls="" class="btn btn-sm btn-raised btn-info" role="tab" data-toggle="tab">Details</a>
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
            {{ $lists->links() }}
        </div>
        <!--seperated customer information section-->
        <div class="col-sm-5">
          <div class="tab-content">
            @foreach($lists as $key=>$list)
              <div role="tabpanel" class="tab-pane fade in @if($key==0) active @endif" id="{{ $list->id}}">
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#basic_{{$list->id}}" aria-controls="basic_{{$list->id}}" role="tab" data-toggle="tab">Basic Info</a></li>
                  <li role="presentation"><a href="#consignee_{{$list->id}}" aria-controls="consignee_{{$list->id}}" role="tab" data-toggle="tab">Consignee & Notify Party</a></li>
                </ul>
                <form class="form-horizontal" action="{{ url('/customer/'.$list->id)}}" method="post" role="form">
                  {!! csrf_field() !!}
                  <input type="hidden" name="_method" value="put" />
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="basic_{{$list->id}}">
                      <div class="form-group">
                        <table class="table table-bordered table-condensed">
                          <tr class="info">
                            <th colspan="4">
                              Basic Info
                            </th>
                          </tr>
                          <tr>
                            <th>客戶編號<br>ID</th>
                            <td><input type="text" class="form-control" name="customer_id" value="{{ $list->customer_id }}"></td>
                            <th>客戶簡稱<br>Short Name</th>
                            <td><input type="text" class="form-control" name="short_name" value="{{ $list->short_name }}"></td>
                          </tr>
                          <tr>
                            <th>中文名稱<br>Company (Chi)</th>
                            <td colspan="3"><input type="text" class="form-control" name="chi_name" value="{{ $list->chi_name }}"></td>
                          </tr>
                          <tr>
                            <th>英文名稱<br>Company (Eng)</th>
                            <td colspan="3"><input type="text" class="form-control" name="eng_name" value="{{ $list->eng_name }}"></td>
                          </tr>
                          <tr>
                            <th>負責人<br>Owner</th>
                            <td>
                              <input type="text" id="respond_person" class="form-control" name="owner" value="{{ $list->owner }}">
                              <!--<button type="button" onclick="copy();" class="btn btn-primary btn-raised btn-sm">Copy</button>-->
                            </td>
                            <th>聯絡人<br>Contact</th>
                            <td><input type="text" id="contact_person" class="form-control" name="contact_person" value="{{ $list->contact_person }}"></td>
                          </tr>
                          <tr>
                            <th>電子郵件<br>Email</th>
                            <td><input type="email" class="form-control" name="email" value="{{ $list->email }}"></td>
                            <th>傳真<br>FAX</th>
                            <td><input type="text" class="form-control" name="fax" value="{{ $list->fax }}"></td>
                          </tr>
                          <tr>
                            <th>電話號碼<br>Phone</th>
                            <td><input type="text" class="form-control" name="phone" value="{{ $list->phone }}"></td>
                            <th>手機號碼<br>Cell Phone</th>
                            <td><input type="text" class="form-control" name="cell_phone" value="{{ $list->cell_phone }}"></td>
                          </tr>
                          <tr>
                            <th>發票抬頭<br>Invoice</th>
                            <td><input type="text" class="form-control" name="invoice" value="{{ $list->invoice }}"></td>
                            <th>支票抬頭<br>Check</th>
                            <td><input type="text" class="form-control" name="check" value="{{ $list->check }}"></td>
                          </tr>
                          <tr>
                            <th>統一編號<br>EIN</th>
                            <td><input type="text" class="form-control" name="EIN" value="{{ $list->EIN }}"></td>
                            <th>國別<br>Nationality</th>
                            <td><input type="text" class="form-control" name="nationality" value="{{ $list->nationality }}"></td>
                          </tr>
                          <tr>
                            <th>幣別<br>Currency</th>
                            <td><input type="text" class="form-control" name="currency" value="{{ $list->currency }}"></td>
                            <th>備註<br>Remark</th>
                            <td><input type="text" class="form-control" name="remark" value="{{ $list->remark }}"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="consignee_{{$list->id}}">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <table class="table table-condensed table-bordered">
                            <tr class="info">
                              <th colspan="8">
                                Notify Party Info
                              </th>
                            </tr>
                            <tr>
                              <td>公司名稱<br>Name</td><td><input type="text" id="notify_name" class="form-control" name="notify_name" value="{{ $list->notify_name }}"></td>
                            </tr>
                            <tr>
                              <td>聯絡人<br>Contact</td><td><input type="text" id="notify_contact" class="form-control" name="notify_contact" value="{{ $list->notify_contact }}"></td>
                            </tr>
                            <tr>
                              <td>電話<br>Phone</td><td><input type="text" id="notify_phone" class="form-control" name="notify_phone" value="{{ $list->notify_phone }}"></td>
                            </tr>
                            <tr>
                              <td>
                                地址<br>Address
                              </td>
                              <td>
                                <!--<input type="text" id="notify_zip" class="form-control" name="notify_zip" value="{{ $list->notify_zip }}" placeholder="Zip Code">-->
                                <textarea name="notify_address" id="notify_address" type="text" rows="5" class="form-control">{{ $list->notify_address }}</textarea>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="8">
                                <button type="button" class="btn btn-block btn-warning btn-raised" onclick="copy_shipping_info();">Copy</button>
                              </td>
                            </tr>
                            <tr class="info">
                              <th colspan="8">
                                Consignee Info
                              </th>
                            </tr>
                            <tr>
                              <td>公司名稱<br>Name</td><td><input type="text" id="consignee_name" class="form-control" name="consignee_name" value="{{ $list->consignee_name }}"></td>
                            </tr>
                            <tr>
                              <td>聯絡人<br>Contact</td><td><input type="text" id="consignee_contact" class="form-control" name="consignee_contact" value="{{ $list->consignee_contact }}"></td>
                            </tr>
                            <tr>
                              <td>電話<br>Phone</td><td><input type="text" id="consignee_phone" class="form-control" name="consignee_phone" value="{{ $list->consignee_phone }}"></td>
                            </tr>
                            <tr>
                              <td>地址<br>Address</td>
                              <!--<td><input type="text" class="form-control" name="consignee_address" ss"></td>-->
                              <td>
                                <!--<input type="text" class="form-control" id="consignee_zip" name="consignee_zip" value="{{ $list->consignee_zip }}" placeholder="Zip Code">-->
                                <textarea name="consignee_address" id="consignee_address" type="text" rows="5" class="form-control">{{ $list->consignee_address }}</textarea>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
                </form>
              </div>
            @endforeach
          </div>
        </div>
    </div>
</div>
@endsection
