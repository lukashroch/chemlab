@extends('app')

@section('title-content')
  {{ trans('user.index') }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'user', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('resource.search', ['module' => 'user'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
