@extends('layouts.app')

@section('content')
@if(count($img)>0)
  @foreach($img as $image)
  <div class="col-sm-10 col-sm-offset-1">
      <a href="/{{ $image->parent }}/{{ $item_id }}"><button type="button" class="btn btn-primary btn-raised">Back</button></a>
      @if(count($item_id)>0)
        <a href="/deleteImage/{{ $image->id }}/{{ $item_id }}"><button type="button" class="btn btn-primary btn-raised">Delete</button></a>
      @else
      <a href="/deleteImage/{{ $image->id }}/index"><button type="button" class="btn btn-primary btn-raised">Delete</button></a>
      @endif
  </div>
  <div class="col-xs-6 col-sm-12">
    <a href="#" class="thumbnail">
      <img src="../../{{ $image->img_url }}">
    </a>
  </div>
  @endforeach
@endif
@endsection
