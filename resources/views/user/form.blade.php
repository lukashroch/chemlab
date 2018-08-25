@extends('app')

@section('title')
  {{ $user->name ?? trans('user.new') }}
@endsection

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'user', 'item' => $user, 'actions' => isset($user->id) ? ['show', 'delete'] : []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab"
           role="tab">{{ $user->name ? trans('common.info') : trans('user.new') }}</a>
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
              @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              @if (isset($user->id))
                <div class="form-control-plaintext form-control-disabled">{{ $user->email }}</div>
              @else
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
                @includeWhen($errors->has('email'), 'partials.error', ['entry' => 'email'])
              @endif
            </div>
          </div>
          <hr>
          <div class="form-group form-row">
            {{ Form::label('teams', trans('team.index'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9">
              @foreach($teams as $team)
                @if(!$team->id)
                  @continue
                @endif
                <div class="px-3 mb-3">
                  <div class="custom-control custom-checkbox mb-2">
                    {{ Form::checkbox('teams[]', $team['id'], $user->hasTeam($team->name), ['class' => 'custom-control-input', 'id' => 'team_'.$team->id]) }}
                    {{ Form::label('team_'.$team->id, $team->display_name, ['class' => 'custom-control-label']) }}
                  </div>
                </div>
              @endforeach
              @includeWhen($errors->has('teams'), 'partials.error', ['entry' => 'teams'])
            </div>
          </div>
          <hr>
          <div class="form-group">
            {{ Form::label('roles', trans('role.index'), ['class' => 'col-form-label']) }}
            <div class="form-row">
              @foreach($teams as $team)
                <div class="col-md-4 px-3 mb-3">
                  <div class="border rounded p-3">
                    <h6>{{ $team->display_name ?? "Global" }}</h6>
                    @foreach($team->roles as $role)
                      <div class="custom-control custom-checkbox mb-2">
                        {{ Form::checkbox('roles['.$team->id.'][]', $role['id'], $user->hasRole($role['name'], $team), ['class' => 'custom-control-input', 'id' => 'role_'.$team->id.'_'.$role['id']]) }}
                        {{ Form::label('role_'.$team->id.'_'.$role['id'], $role['display_name'], ['class' => 'custom-control-label']) }}
                      </div>
                    @endforeach
                  </div>
                </div>
                @includeWhen($errors->has('roles['.$team->id.']'), 'partials.error', ['entry' => 'roles['.$team->id.']'])
              @endforeach
              @includeWhen($errors->has('roles'), 'partials.error', ['entry' => 'roles'])
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

    </div>
  </div>
@endsection
