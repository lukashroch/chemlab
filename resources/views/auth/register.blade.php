@extends('app')

@section('title-content')
  {{ trans('user.registration') }}
@endsection

@section('head-content')
  <li>{{ trans('user.registration') }}</li>
@endsection

@section('content')

  <div class="row">
    <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.registration') }}</div>
        <div class="panel-body">
          {{ Form::open(['url' => '/auth/register', 'method' => 'post', 'class' => 'form-horizontal']) }}
          <div class="form-group">
            {{ Form::label('name', trans('user.name'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              {{ Form::input('text', 'name', old('name'), ['class' => 'form-control due', 'placeholder' => trans('user.name')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              {{ Form::input('email', 'email', old('email'), ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('password_confirmation', trans('user.password_confirmation'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.confirmation')]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              {!! Helper::icon('common.submit') !!}
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
