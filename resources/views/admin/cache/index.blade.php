@extends('app')

@section('title')
  {{ trans('cache.title')}}
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h6 class="card-title">{{ trans('cache.index') }}</h6>
      <div class="card-tools">
        <a class="btn btn-secondary" href="{{ route('cache.clear') }}">
          <span class="fas fa-trash" aria-hidden="true"></span> {{ trans('cache.clear') }}
        </a>
      </div>
    </div>
    <table class="table table-hover">
      @if ($cache)
        <thead>
        <tr>
          <th>{{ trans('common.name') }}</th>
          <th>{{ trans('common.count') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cache as $key => $value)
          <tr>
            <td><span class="fas fa-admin-cache-show" aria-hidden="true"></span> {{ $key }}</td>
            <td>{{ $value }}</td>
          </tr>
        @endforeach
        </tbody>
      @else
        <tbody>
        <tr>
          <td colspan="2">{{ trans('cache.none') }}</td>
        </tr>
        </tbody>
      @endif
    </table>
  </div>
@endsection
