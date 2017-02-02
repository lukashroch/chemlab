@extends('app')

@section('title-content')
  {{ trans('permission.title') }} | {{ $permission->name or trans('permission.new') }}
@endsection

@section('head-content')
  @if (isset($permission->id))
    @include('partials.header', ['module' => 'permission', 'action' => 'edit', 'data' => ['id' => $permission->id, 'name' => $permission->display_name]])
  @else
    @include('partials.header', ['module' => 'permission', 'action' => 'create', 'data' => ['name' => trans('permission.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'permission', 'item' => $permission, 'actions' => isset($permission->id) ? ['show', 'delete'] : []])
        <div class="panel-body">
          @if (isset($permission->id))
            {{ Form::model($permission, ['method' => 'PATCH', 'route' => ['permission.update', $permission->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($permission, ['route' => ['permission.store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('permission.name.internal'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              @if (isset($permission->id))
                <p class="form-control-static">{{ $permission->name }}</p>{{ Form::hidden('id') }}
              @else
                {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('permission.name.internal')]) }}
              @endif
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('display_name', trans('permission.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'display_name', null, ['class' => 'form-control due', 'placeholder' => trans('permission.name')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('permission.description'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('permission.description')]) }}</div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-6">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
