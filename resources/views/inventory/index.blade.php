@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          倉儲資訊 / Inventory
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a href="{{ url('/inventory/create')}}"><button type="button" class="btn btn-primary btn-raised">新增 / create</button></a>
          <a href="{{ url('/setKits')}}"><button type="button" class="btn btn-primary btn-raised">設定套件 / kits</button></a>
        </div>
      </div>
      <div class="col-sm-7">
          @if (count($lists) > 0)
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>品號<br><small>Item ID</small></th>
                <th>類別<br><small>Category</small></th>
                <th class="col-sm-2">品名<br><small>Item Name</small></th>
                <th>實際庫存<br><small>Inventory</small></th>
                <th>預約庫存<br><small>Preserved</small></th>
                <th>可用庫存<br><small>Available</small></th>
                <th class="col-sm-3">操作<br><small>Actions</small></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($lists as $list)
              <tr>
                <td>
                  <a>{{ $list->item_id }}</a>
                </td>
                <td>
                  {{ $list->category }}
                </td>
                <td>
                  {{ $list->item_name }}
                </td>
                <td>
                  {{ $list->inventory - $list->shipped_inv }}
                </td>
                <td>
                  {{ $list->preserved_inv }}
                </td>
                <td class="danger">
                  {{ $list->inventory - $list->preserved_inv - $list->shipped_inv }}
                </td>
                <td>
                  <div class="btn-group">
                    <!--<button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('inventory.show', $list->id) }}'">Details</button>-->
                    <a href="#{{ $list->id }}" aria-controls="" class="btn btn-sm btn-raised btn-info" role="tab" data-toggle="tab">Details</a>
                    <button type="button" class="btn btn-info dropdown-toggle btn-raised btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li align="center">
                        <form class="form-horizontal" action="{{ url('/inventory/'.$list->id)}}" method="post" role="form">
                          {!! csrf_field() !!}
                          <input type="hidden" name="_method" value="delete" />
                          <input type="submit" class="btn btn-sm btn-danger" value="Delete">
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
      <!--seperated invenotry information section-->
      <div class="col-sm-5">
        <!--add each inventory data into tab content divs so it can be shown with javascript-->
        <div class="tab-content">
          @foreach($lists as $key => $list)
          <div role="tabpanel" class="tab-pane fade @if($key ==0 ) in active @endif" id="{{ $list->id }}">
            <!--<div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <button type="button" class="btn btn-raised btn-default" data-toggle="modal" data-target="#addImage">
                    新增圖片/Add Image
                  </button>
                </div>
                @if(count($img)>0)
                  @foreach($img as $image)
                  <div class="col-xs-6 col-sm-6">
                    <a href="{{ url('/viewImage/'.$image->id.'/'.$list->id)}}" class="thumbnail">
                      <img src="../{{ $image->img_url }}">
                    </a>
                  </div>
                  @endforeach
                @endif
              </div>

              <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Add Image</h4>
                    </div>
                    <form class="" action="{{ url('/addImage/inventory/'.$list->item_id.'/'.$list->id)}}" method="post" enctype="multipart/form-data">
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
            </div>-->
            <div class="col-sm-12">
              <form class="form-horizontal" action="{{ url('/inventory/'.$list->id)}}" method="post" role="form">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="put" />
                <div class="form-group">
                  <table class="table table-bordered table-condensed">
                    <tr class="success"><td colspan="4"><h3>{{ $list->item_name }}</h3></td></tr>
                    <tr>
                      <th class="col-sm-3">品號<br>Item ID</th><td class="col-sm-3"><input type="text" class="form-control" name="item_id" value="{{ $list->item_id }}"></td>
                      <th class="col-sm-3">類別<br>Category</th><td class="col-sm-3"><input type="text" class="form-control" name="category" value="{{ $list->category }}"></td>
                    </tr>
                    <tr>
                      <th>品名<br>Item Name</th><td><input type="text" class="form-control" name="item_name" value="{{ $list->item_name }}"></td>
                      <th>中文品名<br>Item Name (Chi)</th><td><input type="text" class="form-control" name="chi_item_name" value="{{ $list->chi_item_name }}"></td>
                    </tr>
                    <tr>
                      <th>庫存<br>Inventory</th>
                      <td>
                        <h4>{{ number_format( $list->inventory-$list->shipped_inv ) }}</h4>
                        <input type="text" class="form-control hidden" name="inventory" value="{{ $list->inventory }}">
                      </td>
                      <th>預約庫存<br>Preserved</th>
                      <td>
                        <h4>{{ number_format( $list->preserved_inv ) }}</h4>
                        <input type="text" class="form-control hidden" name="preserved_inv" value="{{ $list->avg_cost }}">
                      </td>
                    </tr>
                    <tr>
                      <th>可用庫存<br>Available</th>
                      <td>
                        <h4>{{ number_format( $list->inventory-$list->preserved_inv-$list->shipped_inv)}}</h4>
                        <input type="text" class="form-control hidden" name="avg_cost" value="{{ $list->avg_cost }}">
                      </td>
                      <th>平均成本<br>Average</th>
                      <td>
                        <h4>{{ number_format( $list->avg_cost ,2)}}</h4>
                        <input type="text" class="form-control hidden" name="avg_cost" value="{{ $list->avg_cost }}">
                      </td>
                    </tr>
                    <tr class="success">
                      <th colspan="4">價格區間 (Pricing Range)</th>
                    </tr>
                    <tr>
                      <th>區間1<br> Range1</th><td><input type="number" step="0.01" min="0" class="form-control" name="price1" value="{{ $list->price1 }}"></td>
                      <th>區間2<br> Range2</th><td><input type="number" step="0.01" min="0" class="form-control" name="price2" value="{{ $list->price2 }}"></td>
                    </tr>
                    <tr>
                      <th>區間3<br> Range3</th><td><input type="number" step="0.01" min="0" class="form-control" name="price3" value="{{ $list->price3 }}"></td>
                      <th>區間4<br> Range4</th><td><input type="number" step="0.01" min="0" class="form-control" name="price4" value="{{ $list->price4 }}"></td>
                    </tr>
                    <tr>
                      <th>區間5<br> Range5</th><td><input type="number" step="0.01" min="0" class="form-control" name="price5" value="{{ $list->price5 }}"></td>
                      <th>區間6<br> Range6</th><td><input type="number" step="0.01" min="0" class="form-control" name="price6" value="{{ $list->price6 }}"></td>
                    </tr>
                    <tr class="success">
                      <th colspan="4">產品資訊 (Informations)</th>
                    </tr>
                    <tr>
                      <th>規格<br> Standards</th><td><input type="text" class="form-control" name="standard" value="{{ $list->standard }}"></td>
                      <th>條碼<br> Barcode</th><td><input type="text" class="form-control" name="barcode" value="{{ $list->barcode }}"></td>
                    </tr>
                    <tr>
                      <th>單位<br> Unit</th><td><input type="text" class="form-control" name="unit" value="{{ $list->unit }}"></td>
                      <th>安全庫存<br> Safety Inventory</th><td><input type="text" class="form-control" name="safety_inventory" value="{{ $list->safety_inventory }}"></td>
                    </tr>
                    <tr>
                      <th>單位重量<br> Unit Weight</th><td><input type="number" step="0.01" min="0" class="form-control" name="unit_weight" value="{{ $list->unit_weight }}"></td>
                      <th>圖號<br>Graph ID</th><td><input type="text" class="form-control" name="graph_id" value="{{ $list->graph_id }}"></td>
                    </tr>
                    <tr>
                      <th>商品描述<br> Descriptions</th><td colspan="3"><input type="text" class="form-control" name="descriptions" value="{{ $list->descriptions }}"></td>
                    </tr>
                    <tr>
                      <th>備註<br> Remarks</th><td colspan="3"><input type="text" class="form-control" name="remark" value="{{ $list->remark }}"></td>
                    </tr>
                  </table>
                </div>
                <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
</div>
@endsection
