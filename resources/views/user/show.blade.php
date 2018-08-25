@extends('app')

@section('title', $user->name)

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'user', 'item' => $user, 'actions' => ['edit', 'delete']])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#teams" data-toggle="tab" role="tab">{{ trans('team.index') }}</a>
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
            <th>{{ trans('user.name') }}</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('user.email') }}</th>
            <td>{{ $user->email }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="roles" role="tabpanel">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>{{ trans('user.roles') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($user->roles->sortBy('display_name') as $role)
            <tr>
              <td>
                <span class="fas fa-role" aria-hidden="true" title="{{ trans('role.title') }}"></span>
                {{ $role->getDisplayNameWithDesc() }}
              </td>
            </tr>
          @empty
            <tr>
              <td>{{ trans('user.roles.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="teams" role="tabpanel">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>{{ trans('user.teams') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($user->teams->sortBy('display_name') as $team)
            <tr>
              <td>
                <span class="fas fa-team" aria-hidden="true" title="{{ trans('team.title') }}"></span>
                {{ $team->display_name }}
              </td>
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
@endsection
