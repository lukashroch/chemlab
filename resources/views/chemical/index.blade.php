@extends('chemical.layout')

@section('title-content')
  {{ trans('chemical.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'index',
    'data' => ['name' => Input::get('store') && !is_array(Input::get('store')) ? $stores[Input::get('store')] : null]])
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
        @include('chemical.partials.list')
      </div>
    </div>
  </div>
@endsection
