@extends('app')

@section('title-content')
  {{ trans('role.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'role', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-search', ['module' => 'role'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
