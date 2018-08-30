@extends('app')

@section('title')
  {{ trans('chemical.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'chemical'])
  <div class="card">
    @include('resource.search', ['resource' => 'chemical', 'selectName' => 'store', 'selectData' => $stores])
    {!! $dataTable->table() !!}
  </div>

  @include('chemical.partials.move')
  @include('chemical.partials.sketcher', ['id' => 'chemical-search-sketcher'])
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
