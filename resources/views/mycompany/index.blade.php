@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-success" role="alert">
            我的公司 / My Company
          </div>
          <div class="btn-group btn-group-justified">
            <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          </div>
        </div>
        <div class="col-sm-9">
          @if (count($show) > 0)
          <form class="form-horizontal" action="{{ url('/mycompany/'.$show->id)}}" method="post" role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="put" />
          <div class="form-group">
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td>公司名稱</td>
                <td><input type="text" class="form-control" name="name" value="{{ $show->name }}"></td>
                <td>英文名稱</td>
                <td><input type="text" class="form-control" name="eng_name" value="{{ $show->eng_name }}"></td>
              </tr>
              <tr>
                <td>E-Mail</td>
                <td><input type="text" class="form-control" name="email" value="{{ $show->email }}"></td>
                <td>統一編號</td>
                <td><input type="text" class="form-control" name="EIN" value="{{ $show->EIN }}"></td>
              </tr>
              <tr>
                <td>網站連結</td>
                <td><input type="text" class="form-control" name="website" value="{{ $show->website }}"></td>
                <td>聯絡人</td>
                <td><input type="text" class="form-control" name="contact_person" value="{{ $show->contact_person }}"></td>
              </tr>
              <tr>
                <td>電話</td>
                <td><input type="text" class="form-control" name="phone" value="{{ $show->phone }}"></td>
                <td>手機</td>
                <td><input type="text" class="form-control" name="cell_phone" value="{{ $show->cell_phone }}"></td>
              </tr>
              <tr>
                <td>FAX</td>
                <td><input type="text" class="form-control" name="fax" value="{{ $show->fax }}"></td>
                <td>電話（國外）</td>
                <td><input type="text" class="form-control" name="address" value="{{ $show->phone_foreign }}"></td>
              </tr>
              <tr>
                <td>地址</td>
                <td colspan="3"><input type="text" class="form-control" name="address" value="{{ $show->address }}"></td>
              </tr>
              <tr>
                <td>英文地址</td>
                <td colspan="3"><input type="text" class="form-control" name="eng_address" value="{{ $show->eng_address }}"></td>
              </tr>
            </table>
          </div>
          <input type="submit" class="btn btn-success btn-raised" value="Submit"/>
          </form>
          @else
          <form class="form-horizontal" action="{{ url('/mycompany/')}}" method="post" role="form">
            {!! csrf_field() !!}
            <table class="table table-condensed table-hover table-bordered">
              <tr>
                <td>公司名稱</td>
                <td><input type="text" class="form-control" name="name" placeholder="Company Name"></td>
                <td>英文名稱</td>
                <td><input type="text" class="form-control" name="eng_name" placeholder="Company Name(Eng)"></td>
              </tr>
              <tr>
                <td>E-Mail</td>
                <td><input type="text" class="form-control" name="email" placeholder="E-Mail"></td>
                <td>統一編號</td>
                <td><input type="text" class="form-control" name="EIN" placeholder="EIN"></td>
              </tr>
              <tr>
                <td>網站連結</td>
                <td><input type="text" class="form-control" name="website" placeholder="Web Site"></td>
                <td>聯絡人</td>
                <td><input type="text" class="form-control" name="contact_person" placeholder="Contact Person"></td>
              </tr>
              <tr>
                <td>電話</td>
                <td><input type="text" class="form-control" name="phone" placeholder="Phone"></td>
                <td>手機</td>
                <td><input type="text" class="form-control" name="cell_phone" placeholder="Cell Phone"></td>
              </tr>
              <tr>
                <td>FAX</td>
                <td><input type="text" class="form-control" name="fax" placeholder="FAX"></td>
                <td>電話（國外）</td>
                <td><input type="text" class="form-control" name="address" value="Phone For Overseas"></td>
              </tr>
              <tr>
                <td>地址</td>
                <td colspan="3"><input type="text" class="form-control" name="address" placeholder="Address"></td>
              </tr>
              <tr>
                <td>英文地址</td>
                <td colspan="3"><input type="text" class="form-control" name="eng_address" placeholder="Address(Eng)"></td>
              </tr>
            </table>
            <div class="form-group">
              <div class="col-sm-6">
                <input type="submit" class="btn btn-success btn-raised" value="Submit"/>
              </div>
            </div>
          </form>
          @endif
        </div>
        <div class="col-sm-3">
          <div class="row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-raised btn-default" data-toggle="modal" data-target="#addImage">
                Change Image
              </button>
            </div>
            @if(count($img)>0)
              @foreach($img as $image)
              <div class="col-sm-12">
                <a href="{{ url('/viewImage/'.$image->id.'/index')}}" class="thumbnail">
                  <img src="{{ $image->img_url }}">
                </a>
              </div>
              @endforeach
            @endif
          </div>

          <!-- Modal -->
          <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Image</h4>
                </div>
                <form class="" action="addImage/mycompany/mycompany/index" method="post" enctype="multipart/form-data">
                  {!! csrf_field() !!}
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" readonly="" class="form-control" placeholder="Browse...">
                    <input type="file" id="fileToUpload" name="fileToUpload" multiple="" onchange="modifyImg(this);">
                  </div>
                  <div class="col-sm-12">
                    <img id="modified_img" src="#" alt="your image"/>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
