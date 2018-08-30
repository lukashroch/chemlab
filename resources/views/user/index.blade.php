@extends('app')

@section('title')
  {{ trans('user.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'user'])

  <div class="card">
    @include('resource.search', ['resource' => 'user', 'selectName' => 'role', 'selectData' => $roles])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
