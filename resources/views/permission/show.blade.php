@extends('app')

@section('title', $permission->display_name)

@section('content')

  <div class="card">
    @component('resource.header', ['resource' => 'permission', 'item' => $permission, 'actions' => ['edit', 'delete']])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#roles" data-toggle="tab" role="tab">{{ trans('role.index') }}</a>
      </li>
    @endcomponent
    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('permission.name') }}</th>
            <td>{{ $permission->display_name }}</td>
          </tr>
          <tr>
            <th>{{ trans('permission.name.internal') }}</th>
            <td>{{ $permission->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('permission.description') }}</th>
            <td>{{ $permission->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="roles" role="tabpanel">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>{{ trans('permission.roles') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($permission->roles->sortBy('display_name') as $role)
            <tr>
              <td>
                <span class="fas fa-role" aria-hidden="true" title="{{ trans('role.title') }}"></span>
                {{ $role->getDisplayNameWithDesc() }}
              </td>
            </tr>
          @empty
            <tr>
              <td>{{ trans('permission.roles.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
