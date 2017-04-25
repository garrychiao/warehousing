@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success" role="alert">
        系統登入紀錄 / System Log
      </div>
      <div class="btn-group btn-group-justified">
        <a href="{{ url('/home') }}"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
      </div>
    </div>
    <!--Login Log Table-->
    <div class="col-sm-12">
      <table class="table table-condensed table-hover table-striped">
        <tr>
          <th>使用者 / User</th>
          <th>登入時間 / Login Time (Oregon)</th>
          <th>IP  Address</th>
          <th>地區 / Location</th>
          <th>緯度 / Latitude</th>
          <th>經度 / Longitude</th>
          <th>時區 / Timezone</th>
        </tr>
        @forelse( $systemlogs as $systemlog)
        <tr>
          <td>{{ $systemlog->name }}</td>
          <td>{{ $systemlog->datetime }}</td>
          <td>{{ $systemlog->ip }}</td>
          <td>{{ $systemlog->city }}, {{ $systemlog->country }}</td>
          <td>{{ $systemlog->lat }}</td>
          <td>{{ $systemlog->lon }}</td>
          <td>{{ $systemlog->timezone }}</td>
        </tr>
        @empty
        <tr>
          <td>--</td>
          <td>--</td>
          <td>--</td>
          <td>--</td>
          <td>--</td>
          <td>--</td>
          <td>--</td>
        </tr>
        @endforelse
      </table>
    </div>
  </div>
</div>
@endsection
