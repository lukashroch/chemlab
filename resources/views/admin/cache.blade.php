@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('head-content')
  {{ trans('admin.title')}}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-default pull-right" href="{{ route('admin.cache.update') }}"><span
                        class="fa fa-admin-cache-update"
                        aria-hidden="true"></span> {{ trans('admin.cache.update') }}</a>
            </div>
          </div>
        </div>
        <div class="panel-body">
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
  </div>
@endsection
