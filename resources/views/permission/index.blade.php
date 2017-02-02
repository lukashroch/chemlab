@extends('app')

@section('title-content')
  {{ trans('permission.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'permission', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'permission'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
