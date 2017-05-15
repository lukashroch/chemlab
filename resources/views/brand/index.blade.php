@extends('app')

@section('title-content')
  {{ trans('brand.index') }}
@endsection

@section('content')
  @component('partials.resource-nav', ['module' => 'brand', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        @include('partials.resource-search', ['module' => 'brand'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
