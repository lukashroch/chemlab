@extends('app')

@section('title-content')
  {{ trans('permission.title') }} | {{ $permission->display_name }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'permission', 'action' => 'show'])
    <li class="breadcrumb-item">{{ $permission->display_name }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'permission', 'item' => $permission, 'actions' => ['edit', 'delete']])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#roles" data-toggle="tab" role="tab">{{ trans('role.index') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <table class="table table-hover" id="role-view">
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
                  <td>{{ HtmlEx::icon('permission.role', ['name' => $role->getDisplayNameWithDesc()]) }}</td>
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
    </div>
  </div>
@endsection
