@extends('app')

@section('title-content')
  {{ trans('team.index') }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'team', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('resource.search', ['module' => 'team'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
