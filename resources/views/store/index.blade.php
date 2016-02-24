@extends('app')

@section('title-content')
  {{ trans('store.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('store', 'index', ['name' => Input::get('department') ? $departments[Input::get('department')] : null]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'store', 'select' => $departments])
        @include('store.partials.list', [$stores, $action])
      </div>
    </div>
  </div>
@endsection
