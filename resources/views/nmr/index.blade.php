@extends('app')

@section('title-content')
  {{ trans('nmr.index') }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'nmr', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('resource.search', $users ? ['module' => 'nmr', 'selectName' => 'user', 'selectData' => $users] :
        ['module' => 'nmr'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
