@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="btn-group btn-group-justified">
          <a href="/home"><button type="button" class="btn btn-primary btn-raised">主控台 / Home</button></a>
        </div>
        <div class="alert alert-danger" role="alert">
          <h3>Not Authorized !</h3>
        </div>
      </div>
    </div>
</div>
@endsection
