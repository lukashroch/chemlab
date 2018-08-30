@extends('app')

@section('title', $team->display_name)

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'team', 'item' => $team, 'actions' => ['edit', 'delete']])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#stores" data-toggle="tab" role="tab">{{ trans('store.index') }}</a>
      </li>
    @endcomponent
    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('team.name') }}</th>
            <td>{{ $team->display_name }}</td>
          </tr>
          <tr>
            <th>{{ trans('team.name.internal') }}</th>
            <td>{{ $team->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('team.description') }}</th>
            <td>{{ $team->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="stores" role="tabpanel">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>{{ trans('team.stores') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($team->stores->sortBy('tree_name') as $store)
            <tr>
              <td>
                <span class="fas fa-store" aria-hidden="true" title="{{ trans('store.title') }}"></span>
                {{ $store->tree_name }}
              </td>
            </tr>
          @empty
            <tr>
              <td>{{ trans('team.stores.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
