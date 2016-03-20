@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'store', 'action' => 'show', 'data' => ['id' => $store->id, 'name' => $store->name]])
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
            <th>{{ trans('store.parent') }}</th>
            <td>{{ $store->parent ? link_to_route('store.show', $store->parent->name, ['store' => $store->id]) : trans('store.parent.none') }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.temp') }}</th>
            <td>{{ trans('store.temp.int', ['min' => $store->temp_min, 'max' => $store->temp_max]) }}</td>
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
