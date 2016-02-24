@extends('app')

@section('title-content')
  {{ trans('department.title') }} | {{ $department->name }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('department', 'show', ['id' => $department->id, 'name' => $department->name]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $department->name }}</div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('department.name') }}</th>
            <td>{{ $department->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('department.prefix') }}</th>
            <td>{{ $department->prefix }}</td>
          </tr>
          <tr>
            <th>{{ trans('department.stores.num') }}</th>
            <td>@if ($department->stores->count())
                <a href="{{ route('store.index') }}?department={{ $department->id }}">{{ $department->stores->count() }}</a>
              @else
                {{ $department->stores->count() }}
              @endif
            </td>
          </tr>
          <tr>
            <th>{{ trans('department.description') }}</th>
            <td>{{ $department->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('department.stores') }}</div>
        @include('store.partials.list', [$stores, $action])
      </div>
    </div>
  </div>
@endsection
