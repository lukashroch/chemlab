@extends('app')

@section('title-content')
  {{ trans('permission.title') }} | {{ $permission->display_name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'permission', 'action' => 'show', 'data' => ['name' => $permission->display_name]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'permission', 'item' => $permission, 'actions' => ['edit', 'delete']])
        <table id="role-view" class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('permission.name.internal') }}</th>
            <td>{{ $permission->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('permission.name') }}</th>
            <td>{{ $permission->display_name }}</td>
          </tr>
          <tr>
            <th>{{ trans('permission.description') }}</th>
            <td>{{ $permission->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('permission.roles') }}</div>
        <table class="table table-hover">
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
@endsection
