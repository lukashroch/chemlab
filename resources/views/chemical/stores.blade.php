@extends('chemical.layout')

@section('title-content')
  {{ trans('chemical.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'store', 'data' => ['name' => $store->tree_name]])
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical'])
        @include('chemical.partials.list')
      </div>
    </div>
  </div>
@endsection

