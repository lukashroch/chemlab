@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'store', 'action' => 'show', 'data' => ['name' => $store->name]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'store', 'item' => $store, 'actions' => ['edit', 'delete']])
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('store.name') }}</th>
            <td>{{ $store->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.abbr_name') }}</th>
            <td>{{ $store->abbr_name }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.parent') }}</th>
            <td>{{ $store->parent ? link_to_route('store.show', $store->parent->name, ['store' => $store->parent->id]) : trans('store.parent.none') }}</td>
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
@endsection
