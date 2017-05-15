@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header form-inline justify-content-between">
          <h6 class="card-title">{{ trans('admin.cache') }}</h6>
          <a class="btn btn-secondary" href="{{ route('admin.cache.clear') }}">
            <span class="fa fa-admin-cache-clear" aria-hidden="true"></span> {{ trans('admin.cache.clear') }}
          </a>
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
                <td><span class="fa fa-admin-cache-show" aria-hidden="true"></span> {{ $key }}</td>
                <td>{{ $value }}</td>
              </tr>
            @endforeach
            </tbody>
          @else
            <tbody>
            <tr>
              <td colspan="2">{{ trans('admin.cache.empty') }}</td>
            </tr>
            </tbody>
          @endif
        </table>
      </div>
    </div>
  </div>
@endsection
