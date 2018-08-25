@extends('app')

@section('title')
  {{ trans('brand.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'brand'])

  <div class="card">
    @include('resource.search', ['resource' => 'brand'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
