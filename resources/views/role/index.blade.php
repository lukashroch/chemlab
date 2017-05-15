@extends('app')

@section('title-content')
  {{ trans('role.index') }}
@endsection

@section('content')
  @component('partials.resource-nav', ['module' => 'role', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('partials.resource-search', ['module' => 'role'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
