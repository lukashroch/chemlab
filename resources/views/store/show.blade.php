@extends('app')

@section('title', $store->name)

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'store', 'item' => $store, 'actions' => ['edit', 'delete']])
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
            <td>{{ $store->parent ? link_to_route('store.show', $store->parent->tree_name, ['store' => $store->parent->id]) : trans('store.parent.none') }}</td>
          </tr>
          <tr>
            <th>{{ trans('team.title') }}</th>
            <td>{{ $store->team ? link_to_route('team.show', $store->team->display_name, ['team' => $store->team->id]) : trans('store.team.none') }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.temp') }}</th>
            <td>{{ trans('store.temp.int', ['min' => $store->temp_min, 'max' => $store->temp_max]) }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.description') }}</th>
            <td>{{ $store->description }}</td>
          </tr>
          <tr>
            <th>{{ trans('store.children') }}</th>
            <td>
              @forelse($store->children as $child)
                {{ link_to_route('store.show', $child->tree_name, ['store' => $child->id])  }}<br/>
              @empty
                {{ trans('store.children.none') }}
              @endforelse
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
