@extends('chemical.layout')

@section('title-content')
  {{ trans('chemical.recent') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'recent',
    'data' => ['name' => Input::get('store') && !is_array(Input::get('store')) ? $stores[Input::get('store')] : null]])
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush

