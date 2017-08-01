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
            <a class="nav-link" href="#perms" data-toggle="tab" role="tab">{{ trans('permission.index') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#users" data-toggle="tab" role="tab">{{ trans('user.index') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#stores" data-toggle="tab" role="tab">{{ trans('role.stores') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <table id="role-view" class="table table-hover">
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
          <div class="tab-pane" id="perms" role="tabpanel">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ trans('role.perms') }}</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($role->perms->sortBy('display_name') as $perm)
                <tr>
                  <td>{{ HtmlEx::icon('role.permission', ['name' => $perm->getDisplayNameWithDesc()]) }}</td>
                </tr>
              @empty
                <tr>
                  <td>{{ trans('role.perms.none') }}</td>
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
                  <td>{{ HtmlEx::icon('role.user', ['name' => $user->name]) }}</td>
                </tr>
              @empty
                <tr>
                  <td>{{ trans('role.users.none') }}</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="stores" role="tabpanel">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ trans('role.stores') }}</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($role->stores->sortBy('tree_name') as $store)
                <tr>
                  <td>{{ HtmlEx::icon('role.store', ['name' => $store->tree_name]) }}</td>
                </tr>
              @empty
                <tr>
                  <td>{{ trans('role.stores.none') }}</td>
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
