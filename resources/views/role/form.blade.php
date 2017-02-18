@extends('app')

@section('title-content')
  {{ trans('role.title') }} | {{ $role->name or trans('role.new') }}
@endsection

@section('head-content')
  @if (isset($role->id))
    @include('partials.header', ['module' => 'role', 'action' => 'edit', 'data' => ['name' => $role->name]])
  @else
    @include('partials.header', ['module' => 'role', 'action' => 'create', 'data' => ['name' => trans('role.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'role', 'item' => $role, 'actions' => isset($role->id) ? ['show', 'delete'] : []])
        <div class="panel-body">
          @if (isset($role->id))
            {{ Form::model($role, ['method' => 'PATCH', 'route' => ['role.update', $role->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($role, ['route' => ['role.store'], 'class' => 'form-horizontal']) }}
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
            <div
                class="col-sm-10 col-md-6">{{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('role.name')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('role.description'), ['class' => 'col-sm-2 control-label']) }}
            <div
                class="col-sm-10 col-md-6">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('role.description')]) }}</div>
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
        <div class="panel panel-success">
          <div class="panel-heading">{{ trans('role.perms.assigned') }}</div>
          <ul class="list-group" id="assigned" data-url="{{ route('role.perm.detach', ['role' => $role->id]) }}">
            @foreach ($role->perms->sortBy('display_name') as $perm)
              @include('role.partials.perm', ['perm' => $perm, 'type' => 'assigned'])
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-danger">
          <div class="panel-heading">{{ trans('role.perms.not-assigned') }}</div>
          <ul class="list-group" id="not-assigned" data-url="{{ route('role.perm.attach', ['role' => $role->id]) }}">
            @foreach ($perms as $perm)
              @include('role.partials.perm', ['perm' => $perm, 'type' => 'not-assigned'])
            @endforeach
          </ul>
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
