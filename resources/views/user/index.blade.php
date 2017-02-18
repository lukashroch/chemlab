@extends('app')

@section('title-content')
  {{ trans('user.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'user', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-search', ['module' => 'user'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
