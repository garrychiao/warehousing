@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          圖片 / Pictures
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
          <a>
            <button type="button" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#addInvImg">
              產品圖片 / Add Inventory Pics
            </button>
          </a>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <table class="table table-bordered table-condense table-hover">
            <tr>
              <th class="col-sm-1">ID</th>
              <th class="col-sm-1">Name</th>
              <th class="col-sm-1">品名</th>
              <th class="col-sm-1">Graph ID</th>
              <th class="col-sm-5">Pictures</th>
            </tr>
            @forelse($inventory as $inv)
            <tr>
              <td>{{ $inv->item_id }}</td>
              <td>{{ $inv->item_name }}</td>
              <td>{{ $inv->chi_item_name }}</td>
              <td>{{ $inv->graph_id}}</td>
              <td>
                <div class="row">
                  @foreach( $img as $i )
                    @if( $i->inv_id == $inv->id)
                    <div class="col-sm-2">
                      <a class="thumbnail" data-toggle="collapse" href="#{{ $i->id }}" aria-expanded="false" aria-controls="{{ $i->id }}">
                        <img src="{{ $i->img_url }}">
                      </a>
                    </div>
                    @endif
                  @endforeach
                </div>
                @foreach( $img as $i )
                  @if( $i->inv_id == $inv->id)
                  <div class="collapse" id="{{ $i->id }}">
                    <div class="well">
                      <img src="{{ $i->img_url }}" width="350">
                      <a href="{{ url('/deleteImage/inventory/'.$i->id )}}" type="button" class="btn btn-raised btn-warning">Delete</a>
                    </div>
                  </div>
                  @endif
                @endforeach
              </td>
            </tr>
            @empty
            <tr>
              <td>null</td><td>null</td><td>null</td><td>null</td><td></td>
            </tr>
            @endforelse
          </table>
        </div>
        {{ $inventory->links() }}
      </div>
      <div class="col-sm-12">
        <!--for inventory pics-->
        <div class="modal fade" id="addInvImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Image</h4>
              </div>
              <form class="" action="addImage/inventory" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
              <div class="modal-body">
                <div class="form-group">
                  <label for="inv_id" class="col-md-2 control-label">Select</label>
                  <div class="col-md-10">
                    <select id="inv_id" name="inv_id" class="form-control">
                        @forelse( $inventory as $inv )
                        <option value="{{ $inv->id }}">{{ $inv->item_id }} {{ $inv->item_name }}</option>
                        @empty
                        <option value="">無資料</option>
                        @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" readonly="" class="form-control" placeholder="Browse...">
                  <input type="file" id="fileToUpload" name="fileToUpload" onchange="modifyImg(this);" required>
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
