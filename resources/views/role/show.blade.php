@extends('app')

@section('title-content')
  {{ trans('role.title') }} | {{ $role->name }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('role', 'show', ['id' => $role->id, 'name' => $role->display_name]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $role->display_name }}</div>
        <table id="role-view" class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('role.name.internal') }}</th>
            <td>{{ $role->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('role.name') }}</th>
            <td>{{ $role->display_name }}</td>
          </tr>
          <tr>
            <th>{{ trans('role.description') }}</th>
            <td>{{ $role->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('role.perms') }}</div>
        <table class="table table-hover">
          <tbody>
          @forelse ($role->perms->sortBy('display_name') as $perm)
            <tr>
              <td>{{ HtmlEx::icon('role.permission', null, $perm->getDisplayNameWithDesc()) }}</td>
            </tr>
          @empty
            <tr>
              <td>{{ trans('role.perms.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('role.users') }}</div>
        <table class="table table-hover">
          <tbody>
          @forelse ($role->users->sortBy('name') as $user)
            <tr>
              <td>{{ HtmlEx::icon('role.user', null, $user->name) }}</td>
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
@endsection
