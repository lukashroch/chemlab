@extends('app')

@section('title-content')
  {{ trans('user.title') }} | {{ $user->name or trans('user.new') }}
@endsection

@section('head-content')
  @if (isset($user->id))
    @include('partials.header', ['module' => 'user', 'action' => 'edit', 'data' => ['name' => $user->name]])
  @else
    @include('partials.header', ['module' => 'user', 'action' => 'create', 'data' => ['name' => trans('user.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'user', 'item' => $user, 'actions' => isset($user->id) ? ['show', 'delete'] : []])
        <div class="panel-body">
          @if (isset($user->id))
            {{ Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($user, ['route' => ['user.store'], 'class' => 'form-horizontal']) }}
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
        <div class="panel panel-success">
          <div class="panel-heading">{{ trans('user.roles.assigned') }}</div>
          <ul class="list-group" id="assigned" data-url="{{ route('user.role.detach', ['user' => $user->id]) }}">
            @foreach ($user->roles->sortBy('display_name') as $role)
              @include('user.partials.role', ['role' => $role, 'type' => 'assigned'])
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-danger">
          <div class="panel-heading">{{ trans('user.roles.not-assigned') }}</div>
          <ul class="list-group" id="not-assigned" data-url="{{ route('user.role.attach', ['user' => $user->id]) }}">
            @foreach ($roles as $role)
              @include('user.partials.role', ['role' => $role, 'type' => 'not-assigned'])
            @endforeach
          </ul>
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
