@extends('layouts.app')

@section('content')
<script type="text/javascript">
function change(input){
  var label = input.parentNode;
  var name = input.getAttribute("name");
  if(input.checked){
    label.style.backgroundColor = '#DCEDC8';
    label.innerHTML = '<input type="checkbox" name="' + name + '" autocomplete="off" onchange="change(this);" value="1" checked> Yes';
  }else{
    label.style.backgroundColor = '#F8BBD0';
    label.innerHTML = '<input type="hidden" name="' + name + '" value="0">';
    label.innerHTML += '<input type="checkbox" autocomplete="off" name="' + name + '" onchange="change(this);"> No';
  }
}
</script>
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success" role="alert">
          員工管理 / Employee
        </div>
        <div class="btn-group btn-group-justified">
          <a href="{{ url('/home')}}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <form class="" action="{{ url('/employee/id') }}" method="post">
              {!! csrf_field() !!}
              <input type="hidden" name="_method" value="put" />
              <table class="table table-condensed table-hover">
                <tr>
                  <td class="col-sm-1">Name</td>
                  <td class="col-sm-2">E-Mail</td>
                  <td>Administrator</td>
                  <td>Customer</td>
                  <td>Inventory</td>
                  <td>Supplier</td>
                  <td>Purchase Invoice</td>
                  <td>Proforma Invoice</td>
                  <td>Commercial Invoice</td>
                  <td>Data Export</td>
                </tr>
                @foreach($user as $key => $u)
                <input type="hidden" name="id[]" value="{{ $u->id }}">
                  <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                      @if($u->administrator)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        @if($key == 0)
                          <input type="hidden" name="administrator[]" value="1" checked>
                          <input type="checkbox" checked disabled>
                          Yes
                        @else
                          <input type="checkbox" autocomplete="off" name="administrator[]" onchange="change(this);" value="1" checked>
                          Yes
                        @endif
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="administrator[]" value="0">
                        <input type="checkbox" name="administrator[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->customer)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="customer[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="customer[]" value="0">
                        <input type="checkbox" name="customer[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->inventory)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="inventory[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="inventory[]" value="0">
                        <input type="checkbox" name="inventory[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->supplier)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="supplier[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="supplier[]" value="0">
                        <input type="checkbox" name="supplier[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->purchase)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="purchase[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="purchase[]" value="0">
                        <input type="checkbox" name="purchase[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->proforma)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="proforma[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="proforma[]" value="0">
                        <input type="checkbox" name="proforma[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->commercial)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="commercial[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="commercial[]" value="0">
                        <input type="checkbox" name="commercial[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                    <td>
                      @if($u->data_export)
                      <label class="btn btn-block" style="background-color:#DCEDC8;">
                        <input type="checkbox" autocomplete="off" name="data_export[]" value="1" onchange="change(this);" checked>
                          Yes
                      </label>
                      @else
                      <label class="btn btn-block" style="background-color:#F8BBD0;">
                        <input type="hidden" name="data_export[]" value="0">
                        <input type="checkbox" name="data_export[]" autocomplete="off" onchange="change(this);"> No
                      </label>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </table>
              <input type="submit" class="btn btn-success btn-raised" value="Submit">
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
