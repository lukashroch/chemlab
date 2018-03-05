@extends('app')

@section('title-content')
  {{ trans('role.title') }} | {{ $role->display_name }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'role', 'action' => 'show'])
    <li class="breadcrumb-item">{{ $role->display_name }}</li>
  @endcomponent

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @component('resource.header', ['module' => 'role', 'item' => $role, 'actions' => ['edit', 'delete']])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#permissions" data-toggle="tab" role="tab">{{ trans('permission.index') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#users" data-toggle="tab" role="tab">{{ trans('user.index') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <table class="table table-hover">
              <tbody>
              <tr>
                <th>{{ trans('role.name') }}</th>
                <td>{{ $role->display_name }}</td>
              </tr>
              <tr>
                <th>{{ trans('role.name.internal') }}</th>
                <td>{{ $role->name }}</td>
              </tr>
              <tr>
                <th>{{ trans('role.description') }}</th>
                <td>{{ $role->description }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="permissions" role="tabpanel">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ trans('role.permissions') }}</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($role->permissions->sortBy('display_name') as $permission)
                <tr>
                  <td>
                    <span class="fa fa-permission" aria-hidden="true" title="{{ trans('permission.title') }}"></span>
                    {{ $permission->getDisplayNameWithDesc() }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td>{{ trans('role.permissions.none') }}</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="users" role="tabpanel">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ trans('role.users') }}</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($role->users->sortBy('name') as $user)
                <tr>
                  <td>
                    <span class="fa fa-user" aria-hidden="true" title="{{ trans('user.title') }}"></span>
                    {{ $user->name }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td>{{ trans('role.users.none') }}</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
