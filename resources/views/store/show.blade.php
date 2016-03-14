@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('store', 'show', ['id' => $store->id, 'name' => $store->name]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $store->name }}</div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('store.name') }}</th>
            <td>{{ $store->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.department') }}</th>
            <td>{{ link_to_route('department.show', $store->department->name, ['id' => $store->department->id]) }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.parent') }}</th>
            <td>{{ $store->parent->name or 'none' }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.temp') }}</th>
            <td>{{ trans('store.temp.int', ['min' => $store->temp_min, 'max' => $store->temp_max]) }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.num_stores') }}</th>
            <td>@if ($store->items->count())
                <a href="{{ route('chemical.index') }}?store={{ $store->id }}">{{ $store->items->count() }}</a>
              @else
                {{ $store->items->count() }}
              @endif
            </td>
          </tr>
          <tr>
            <th>{{ trans('store.description') }}</th>
            <td>{{ $store->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('store.chemicals') }}</div>
        @include('chemical.partials.list', [$chemicals, $action])
      </div>
    </div>
  </div>
@endsection
