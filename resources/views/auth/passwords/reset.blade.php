@extends('app')

@section('title-content')
  {{ trans('user.password.reset') }}
@endsection

@section('head-content')
  <li>{{ trans('user.password.reset') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.password.reset') }}</div>
        <div class="panel-body">
          {{ Form::open(['url' => '/password/reset', 'role' => 'form', 'method' => 'post', 'class' => 'form-horizontal']) }}
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
                {{ Form::input('hidden', 'token', $token, ['class' => 'form-control due']) }}
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.new')]) }}
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.confirmation')]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              {{ Form::submit(trans('common.submit'), ['class' => 'btn btn-primary']) }}
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
