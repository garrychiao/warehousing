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
                    <button type="button" target="center" class="btn btn-info btn-raised btn-sm" onclick="window.location.href='{{ URL::route('inventory.show', $list->id) }}'">Details</button>
                    <button type="button" class="btn btn-info dropdown-toggle btn-raised btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li align="center">
                        <form class="form-horizontal" action="{{ url('/inventory/'.$list->id)}}" method="post" role="form">
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
      <!--seperated invenotry information section-->
      <div class="col-sm-5">
        @if( count ( $show ) > 0 )
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-raised btn-default" data-toggle="modal" data-target="#addImage">
                新增圖片/Add Image
              </button>
            </div>
            @if(count($img)>0)
              @foreach($img as $image)
              <div class="col-xs-6 col-sm-6">
                <a href="{{ url('/viewImage/'.$image->id.'/'.$show->id)}}" class="thumbnail">
                  <img src="../{{ $image->img_url }}">
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
                <form class="" action="{{ url('/addImage/inventory/'.$show->item_id.'/'.$show->id)}}" method="post" enctype="multipart/form-data">
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
        <div class="col-sm-12">
          <form class="form-horizontal" action="{{ url('/inventory/'.$show->id)}}" method="post" role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="put" />
            <div class="form-group">
              <table class="table table-bordered table-condensed">
                <tr class="success"><td colspan="4"><h3>{{ $show->item_name }}</h3></td></tr>
                <tr>
                  <th class="col-sm-3">品號<br>Item ID</th><td class="col-sm-3"><input type="text" class="form-control" name="item_id" value="{{ $show->item_id }}"></td>
                  <th class="col-sm-3">類別<br>Category</th><td class="col-sm-3"><input type="text" class="form-control" name="category" value="{{ $show->category }}"></td>
                </tr>
                <tr>
                  <th>品名<br>Item Name</th><td><input type="text" class="form-control" name="item_name" value="{{ $show->item_name }}"></td>
                  <th>圖號<br>Graph ID</th><td><input type="text" class="form-control" name="graph_id" value="{{ $show->graph_id }}"></td>
                </tr>
                <tr>
                  <th>庫存<br>Inventory</th>
                  <td>
                    <h4>{{ number_format( $show->inventory-$show->shipped_inv ) }}</h4>
                    <input type="text" class="form-control hidden" name="inventory" value="{{ $show->inventory }}">
                  </td>
                  <th>預約庫存<br>Preserved</th>
                  <td>
                    <h4>{{ number_format( $show->preserved_inv ) }}</h4>
                    <input type="text" class="form-control hidden" name="preserved_inv" value="{{ $show->avg_cost }}">
                  </td>
                </tr>
                <tr>
                  <th>可用庫存<br>Available</th>
                  <td>
                    <h4>{{ number_format( $show->inventory-$show->preserved_inv-$show->shipped_inv)}}</h4>
                    <input type="text" class="form-control hidden" name="avg_cost" value="{{ $show->avg_cost }}">
                  </td>
                  <th>平均成本<br>Average</th>
                  <td>
                    <h4>{{ number_format( $show->avg_cost ,2)}}</h4>
                    <input type="text" class="form-control hidden" name="avg_cost" value="{{ $show->avg_cost }}">
                  </td>
                </tr>
                <tr class="success">
                  <th colspan="4">價格區間 (Pricing Range)</th>
                </tr>
                <tr>
                  <th>區間1<br> Range1</th><td><input type="number" step="0.01" min="0" class="form-control" name="price1" value="{{ $show->price1 }}"></td>
                  <th>區間2<br> Range2</th><td><input type="number" step="0.01" min="0" class="form-control" name="price2" value="{{ $show->price2 }}"></td>
                </tr>
                <tr>
                  <th>區間3<br> Range3</th><td><input type="number" step="0.01" min="0" class="form-control" name="price3" value="{{ $show->price3 }}"></td>
                  <th>區間4<br> Range4</th><td><input type="number" step="0.01" min="0" class="form-control" name="price4" value="{{ $show->price4 }}"></td>
                </tr>
                <tr>
                  <th>區間5<br> Range5</th><td><input type="number" step="0.01" min="0" class="form-control" name="price5" value="{{ $show->price5 }}"></td>
                  <th>區間6<br> Range6</th><td><input type="number" step="0.01" min="0" class="form-control" name="price6" value="{{ $show->price6 }}"></td>
                </tr>
                <tr class="success">
                  <th colspan="4">產品資訊 (Informations)</th>
                </tr>
                <tr>
                  <th>規格<br> Standards</th><td><input type="text" class="form-control" name="standard" value="{{ $show->standard }}"></td>
                  <th>條碼<br> Barcode</th><td><input type="text" class="form-control" name="barcode" value="{{ $show->barcode }}"></td>
                </tr>
                <tr>
                  <th>單位<br> Unit</th><td><input type="text" class="form-control" name="unit" value="{{ $show->unit }}"></td>
                  <th>安全庫存<br> Safety Inventory</th><td><input type="text" class="form-control" name="safety_inventory" value="{{ $show->safety_inventory }}"></td>
                </tr>
                <tr>
                  <th>單位重量<br> Unit Weight</th><td colspan="3"><input type="number" step="0.01" min="0" class="form-control" name="unit_weight" value="{{ $show->unit_weight }}"></td>
                </tr>
                <tr>
                  <th>商品描述<br> Descriptions</th><td colspan="3"><input type="text" class="form-control" name="descriptions" value="{{ $show->descriptions }}"></td>
                </tr>
                <tr>
                  <th>備註<br> Remarks</th><td colspan="3"><input type="text" class="form-control" name="remark" value="{{ $show->remark }}"></td>
                </tr>
              </table>
            </div>
<!--
            <div class="form-group">
              <label class="col-sm-2 control-label">品號</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="item_id" value="{{ $show->item_id }}">
              </div>
              <label class="col-sm-2 control-label">類別</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="category" value="{{ $show->category }}">
              </div>
              <label class="col-sm-2 control-label">品名</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="item_name" value="{{ $show->item_name }}">
              </div>
              <label class="col-sm-2 control-label">圖號</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="graph_id" value="{{ $show->graph_id }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">庫存</label>
              <div class="col-sm-4">
                <h4>{{ $show->inventory }}</h4>
                <input type="text" class="form-control hidden" name="inventory" value="{{ $show->inventory }}">
              </div>
              <label class="col-sm-2 control-label">平均成本</label>
              <div class="col-sm-4">
                <h4>{{ number_format( $show->avg_cost ,2)}}</h4>
                <input type="text" class="form-control hidden" name="avg_cost" value="{{ $show->avg_cost }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">價格區間1</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price1" value="{{ number_format($show->price1,2) }}">
              </div>
              <label class="col-sm-3 control-label">價格區間2</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price2" value="{{ number_format($show->price2,2) }}">
              </div>
              <label class="col-sm-3 control-label">價格區間3</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price3" value="{{ number_format($show->price3,2) }}">
              </div>
              <label class="col-sm-3 control-label">價格區間4</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price4" value="{{ number_format($show->price4,2) }}">
              </div>
              <label class="col-sm-3 control-label">價格區間5</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price5" value="{{ number_format($show->price5,2) }}">
              </div>
              <label class="col-sm-3 control-label">價格區間6</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="price6" value="{{ number_format($show->price6,2) }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">規格</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="standard" value="{{ $show->standard }}">
              </div>
              <label class="col-sm-2 control-label">條碼</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="barcode" value="{{ $show->barcode }}">
              </div>
              <label class="col-sm-2 control-label">單位</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="unit" value="{{ $show->unit }}">
              </div>
              <label class="col-sm-2 control-label">安全庫存</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="safety_inventory" value="{{ $show->safety_inventory }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">商品描述</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="descriptions" value="{{ $show->descriptions }}">
              </div>
              <label class="col-sm-2 control-label">備註</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="remark" value="{{ $show->remark }}">
              </div>
            </div>-->
            <input type="submit" class="btn btn-success btn-raised" value="修改/Update"/>
          </form>
        </div>
        @endif
      </div>
    </div>
</div>
@endsection
