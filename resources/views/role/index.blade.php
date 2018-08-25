@extends('app')

@section('title')
  {{ trans('role.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'role'])

  <div class="card">
    @include('resource.search', ['resource' => 'role'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
