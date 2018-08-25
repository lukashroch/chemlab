@extends('app')

@section('title')
  {{ trans('team.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'team'])

  <div class="card">
    @include('resource.search', ['resource' => 'team'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
