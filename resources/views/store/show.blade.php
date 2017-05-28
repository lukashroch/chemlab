@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'store', 'action' => 'show'])
    <li class="breadcrumb-item">{{ $store->name }}</li>
  @endcomponent

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @component('resource.header', ['module' => 'store', 'item' => $store, 'actions' => ['edit', 'delete']])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ trans('common.info') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
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
    </div>
  </div>
@endsection
