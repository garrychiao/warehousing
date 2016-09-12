@extends('layouts.app')

@section('content')
<div class="col-sm-8 col-sm-offset-2">
  <h3>{{ $list->chi_name }}</h3>
  <h3>{{ $list->eng_name }}</h3>
  <h3>{{ $list->email }}</h3>
  <h3>{{ $list->EIN }}</h3>
  <h3>{{ $list->phone }}</h3>
  <h3>{{ $list->cell_phone }}</h3>
  <h3>{{ $list->contact_zip_code }}{{ $list->contact_address }}</h3>
  <h3>{{ $list->recieve_zip_code }}{{ $list->recieve_address }}</h3>

</div>


<p>
Created on: {{ date('F d, Y', strtotime($list->created_at)) }} <br />
Last modified: {{ date('F d, Y', strtotime($list->updated_at)) }}<br />
{{ $list->description }}
</p>


@endsection
