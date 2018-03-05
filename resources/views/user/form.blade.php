@extends('app')

@section('title-content')
  {{ trans('user.title') }} | {{ $user->name or trans('user.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($user->id) ? ['module' => 'user', 'action' => 'edit']
  : ['module' => 'user', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($user->id) ? $user->name : trans('user.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'user', 'item' => $user, 'actions' => isset($user->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $user->name ? trans('common.info') : trans('user.new') }}</a>
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
            <div class="card-body">
              {{ Form::model($user, isset($user->id) ? ['method' => 'PATCH', 'route' => ['user.update', $user->id]]
              : ['route' => ['user.store']]) }}
              <div class="form-group form-row">
                {{ Form::label('name', trans('user.name'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('user.name')]) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('email', trans('user.email'), ['class' => 'col-md-3 col-form-label']) }}
                <div class="col-md-9 col-lg-6">
                  @if (isset($user->id))
                    <p class="form-control-static">{{ $user->email }}</p>{{ Form::hidden('id') }}
                  @else
                    {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
                  @endif
                </div>
              </div>
              <div class="form-group form-row justify-content-center">
                <div class="col-auto">
                  @include('partials.actions.save')
                </div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
          <div class="tab-pane" id="roles" role="tabpanel">
            <div class="row p-3">
              {{ Form::label('role', trans('store.parent'), ['class' => 'col-md-2 col-form-label']) }}
              <div class="col-md-3">
                {{ Form::select('team_id', $teams, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
              <div class="col-md-3">
                {{ Form::select('role_id', $roles, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
              <div class="col-md-3">
                <button class="btn btn-success">{{ trans('common.add') }}</button>
              </div>
            </div>
            <div class="row">
              @if (isset($user->id))
                <div class="col">
                  <table class="table table-hover assigned"
                         data-url="{{ route('user.role.detach', ['user' => $user->id, 'role' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('user.roles.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user->roles->sortBy('display_name') as $role)
                      @include('user.partials.role', ['role' => $role, 'action' => 'detach'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-block">{{ trans('user.roles.header') }}</div>
                </div>
              @endif
            </div>
          </div>

          <div class="tab-pane" id="teams" role="tabpanel">
            <div class="row">
              @if (isset($user->id))
                <div class="col-md-6 pr-md-0">
                  <table class="table table-hover assigned"
                         data-url="{{ route('user.team.detach', ['user' => $user->id, 'team' => 'ph']) }}">
                    <thead>
                    <tr class="table-success">
                      <th>{{ trans('user.teams.assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user->teams->sortBy('display_name') as $team)
                      @include('user.partials.team', ['team' => $team, 'action' => 'detach'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 pl-md-0">
                  <table class="table table-hover not-assigned"
                         data-url="{{ route('user.team.attach', ['user' => $user->id, 'team' => 'ph']) }}">
                    <thead>
                    <tr class="table-danger">
                      <th>{{ trans('user.teams.not-assigned') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($teams as $team)
                      @include('user.partials.team', ['team' => $team, 'action' => 'attach'])
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-md-12">
                  <div class="card-block">{{ trans('user.teams.header') }}</div>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
