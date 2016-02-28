@extends('app')

@section('title-content')
  {{ trans('chemical.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('chemical', 'index', ['name' => Input::get('store') && !is_array(Input::get('store')) ? $stores[Input::get('store')] : null]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
        @include('chemical.partials.list', [$chemicals, $action])
      </div>
    </div>
  </div>
@endsection
