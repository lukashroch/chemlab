@extends('app')

@section('title-content')
  {{ trans('role.title') }} | {{ $role->name or trans('role.new') }}
@endsection

@section('head-content')
  @if (isset($role->id))
    {{ HtmlEx::menu('role', 'edit', ['id' => $role->id, 'name' => $role->display_name]) }}
  @else
    {{ HtmlEx::menu('role', 'create', ['name' => trans('role.new')]) }}
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $role->display_name or trans('role.new') }}</div>
        <div class="panel-body">
          @if (isset($role->id))
            {{ Form::model($role, ['method' => 'PATCH', 'action' => ['RoleController@update', $role->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($role, ['action' => ['RoleController@store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('role.name.internal'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              @if (isset($role->id))
                <p class="form-control-static">{{ $role->name }}</p>{{ Form::hidden('id') }}
              @else
                {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name.internal')]) }}
              @endif
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('display_name', trans('role.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('role.description'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('role.description')]) }}</div>
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
    @if (isset($role->id))
      <div class="col-sm-6">
        <div class="panel panel-success" id="role-edit-perms-assigned">
          <div class="panel-heading">{{ trans('role.perms.assigned') }}</div>
          <div class="list-group" id="perms-assigned">
            @forelse ($role->perms->sortBy('display_name') as $perm)
              <a href="#"
                 class="list-group-item {{ !Auth::user()->canHandlePermission($perm->name, $role->name) ? 'disabled' : '' }}"
                 id="{{ $perm['id'] }}">{{ HtmlEx::icon('role.permission', null, ['name' => $perm->getDisplayNameWithDesc()]) }}</a>
            @empty
              <a href="#" class="list-group-item disabled">{{ trans('role.perms.drag')}}</a>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-danger" id="role-edit-perms-not-assigned">
          <div class="panel-heading">{{ trans('role.perms.notassigned') }}</div>
          <div class="list-group" id="perms-not-assigned">
            @forelse ($perms as $perm)
              <a href="#"
                 class="list-group-item {{ !Auth::user()->canHandlePermission($perm->name)  ? 'disabled' : '' }}"
                 id="{{ $perm->id }}">{{ HtmlEx::icon('role.permission', null, ['name' => $perm->getDisplayNameWithDesc()]) }}</a>
            @empty
              <a href="#" class="list-group-item disabled">{{ trans('role.perms.drag')}}</a>
            @endforelse
          </div>
        </div>
      </div>
    @else
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('role.perms.assigned') }}</div>
          <div class="panel-body">{{ trans('role.perms.header') }}</div>
        </div>
      </div>
    @endif
  </div>
@endsection
