@extends('app')

@section('title-content')
  {{ trans('department.title') }} | {{ $department->name or trans('department.new') }}
@endsection

@section('head-content')
  @if (isset($department->id))
    {{ HtmlEx::menu('department', 'edit', ['id' => $department->id, 'name' => $department->name]) }}
  @else
    {{ HtmlEx::menu('department', 'create', ['name' => trans('department.new')]) }}
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $department->name or trans('department.new') }}</div>
        <div class="panel-body">
          @if (isset($department->id))
            {{ Form::model($department, ['method' => 'PATCH', 'action' => ['DepartmentController@update', $department->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($department, ['action' => ['DepartmentController@store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('department.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('department.name')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('prefix', trans('department.prefix'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'prefix', null, ['class' => 'form-control due', 'placeholder' => trans('department.prefix')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('department.description'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('department.description')]) }}</div>
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
