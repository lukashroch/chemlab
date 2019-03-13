@extends('app')

@section('title', __('audits.index'))

@section('content')
  @include('partials.actionbar', ['resource' => 'audits'])

  <div class="card">
    @include('resource.search', ['resource' => 'audits'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
