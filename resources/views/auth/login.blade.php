@extends('app')

@section('title-content')
  {{ trans('user.log.in') }}
@endsection

@section('head-content')
  <li>{{ trans('user.log.in')}}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.log.in')}}</div>
        <div class="panel-body">
            {{ Form::open(array('url' => '/login', 'role' => 'form', 'method' => 'post', 'class' => 'form-horizontal')) }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-2 control-label']) }}
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
                  {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {{ Form::label('password', trans('user.password'), ['class' => 'col-sm-2 control-label']) }}
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                  {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password')]) }}
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox col-sm-offset-2 col-sm-10">
                <label for="remember">
                  {{ Form::input('checkbox', 'remember') }} {{ trans('user.remember') }}
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                {{ Form::button('<span class="fa fa-user-log-in" aria-hidden="true"></span> '.trans('user.log.in'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
              </div>
            </div>
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  <p class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">{{ link_to('password/reset', trans('user.password.forgot')) }}</p>
@endsection
