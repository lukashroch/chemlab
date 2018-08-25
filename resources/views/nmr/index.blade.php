@extends('app')

@section('title')
  {{ trans('nmr.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'brand'])

  <div class="card">
    @include('resource.search', $users ? ['resource' => 'nmr', 'selectName' => 'user', 'selectData' => $users] :
    ['resource' => 'nmr'])
    {!! $dataTable->table() !!}
  </div>
@endsection

@push('scripts')
  {!! $dataTable->scripts() !!}
@endpush
