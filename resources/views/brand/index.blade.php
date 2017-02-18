@extends('app')

@section('title-content')
  {{ trans('brand.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'brand', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-search', ['module' => 'brand'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
