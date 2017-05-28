@extends('app')

@section('title-content')
  {{ trans('permission.index') }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'permission', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('resource.search', ['module' => 'permission'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
