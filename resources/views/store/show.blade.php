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
          @if ($store->children->isEmpty())
            <li class="nav-item">
              <a class="nav-link" href="#roles" data-toggle="tab"
                 role="tab">{{ trans('store.roles') }}</a>
            </li>
          @endif
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
          @if ($store->children->isEmpty())
            <div class="tab-pane" id="roles" role="tabpanel">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th>{{ trans('store.roles') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($store->roles->sortBy('display_name') as $role)
                  <tr>
                    <td>{{ HtmlEx::icon('permission.role', ['name' => $role->display_name]) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td>{{ trans('store.roles.none') }}</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
