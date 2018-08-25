@extends('app')

@section('title')
  {{ trans('permission.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'permission'])

  <div class="card">
    @include('resource.search', ['resource' => 'permission'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
