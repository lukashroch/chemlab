@extends('app')

@section('title-content')
  {{ trans('user.title') }} | {{ $user->name or trans('user.new') }}
@endsection

@section('head-content')
  @if (isset($user->id))
    @include('partials.header', ['module' => 'user', 'action' => 'edit', 'data' => ['id' => $user->id, 'name' => $user->name]])
  @else
    @include('partials.header', ['module' => 'user', 'action' => 'create', 'data' => ['name' => trans('user.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $user->name or trans('user.new') }}</div>
        <div class="panel-body">
          @if (isset($user->id))
            {{ Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($user, ['action' => ['UserController@store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('user.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('user.name')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              @if (isset($user->id))
                <p class="form-control-static">{{ $user->email }}</p>{{ Form::hidden('id') }}
              @else
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-6">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  <br/>
  <div class="row">
    @if (isset($user->id))
      <div class="col-sm-6">
        <div class="panel panel-success" id="user-edit-roles-assigned">
          <div class="panel-heading">{{ trans('user.roles.assigned') }}</div>
          <div class="list-group" id="roles-assigned">
            @forelse ($user->roles->sortBy('display_name') as $role)
              <a href="#"
                 class="list-group-item {{ !Auth::user()->canHandleRole($role->name) ? 'disabled' : '' }}"
                 id="{{ $role->id }}">{{ HtmlEx::icon('user.role', null, ['name' => $role->getDisplayNameWithDesc()]) }}</a>
            @empty
              <a href="#" class="list-group-item disabled">{{ trans('user.roles.drag') }}</a>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-danger" id="user-edit-roles-not-assigned">
          <div class="panel-heading">{{ trans('user.roles.notassigned') }}</div>
          <div class="list-group" id="roles-not-assigned">
            @forelse ($roles as $role)
              <a href="#" class="list-group-item {{ !Auth::user()->canHandleRole($role->name) ? 'disabled' : '' }}"
                 id="{{ $role->id }}">{{ HtmlEx::icon('user.role', null, ['name' => $role->getDisplayNameWithDesc()]) }}</a>
            @empty
              <a href="#" class="list-group-item disabled">{{ trans('user.roles.drag') }}</a>
            @endforelse
          </div>
        </div>
      </div>
    @else
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('user.roles.assigned') }}</div>
          <div class="panel-body">{{ trans('user.roles.header') }}</div>
        </div>
      </div>
    @endif
  </div>
@endsection
