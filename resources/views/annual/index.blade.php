@extends('layouts.app')

@section('content')
<script type="text/javascript">
function check_all(obj,cName)
{
  var checkboxs = document.getElementsByName(cName);
  for(var i=0;i<checkboxs.length;i++){
    checkboxs[i].checked = obj.checked;
  }
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          資料輸出 / Data Export
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
        </div>
        <div class="col-sm-12">
          <!--Inventory Informations-->
          <div class="col-sm-12">
            <h2>Inventory</h2>
            <div class="form-group">
              <form class="" action="{{ url('/information/inventory') }}" method="post">
                {!! csrf_field() !!}
                <table class="table table-condensed table-bordered table-hover table-striped">
                  <tr>
                    <td>
                      <input type="checkbox" onclick="check_all(this,'inventory[]')"> 全選
                    </td>
                    <td>ID</td>
                    <td>名稱</td>
                    <td>內容</td>
                    <td>重量(per)</td>
                    <td>價格1</td>
                    <td>價格2</td>
                    <td>價格3</td>
                    <td>價格4</td>
                    <td>價格5</td>
                    <td>價格6</td>
                  </tr>
                  @forelse($inventory as $inv)
                  <tr>
                    <td>
                      <input type="checkbox" name="inventory[]" value="{{ $inv->id}}">
                    </td>
                    <td>{{ $inv->item_id}}</td>
                    <td>{{ $inv->item_name}}</td>
                    <td>{{ $inv->descriptions}}</td>
                    <td>{{ $inv->unit_weight}}</td>
                    <td>{{ $inv->price1}}</td>
                    <td>{{ $inv->price2}}</td>
                    <td>{{ $inv->price3}}</td>
                    <td>{{ $inv->price4}}</td>
                    <td>{{ $inv->price5}}</td>
                    <td>{{ $inv->price6}}</td>
                  </tr>
                  @empty
                  <tr>
                    <td></td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                    <td>無資料</td>
                  </tr>
                  @endforelse
                </table>
                <input type="submit" name="name" class="btn btn-success btn-raised" value="Export">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
