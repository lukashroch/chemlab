@extends('app')

@section('title-content')
  {{ trans('user.password.reset') }}
@endsection

@section('head-content')
  <li>{{ trans('user.password.reset') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12 col-md-8 col-lg-6 mx-auto">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">{{ trans('user.password.reset') }}</h6>
        </div>
        <div class="card-body">
          {{ Form::open(['url' => '/password/reset', 'role' => 'form', 'method' => 'post']) }}
          {{ csrf_field() }}
          <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
                {{ Form::input('hidden', 'token', $token, ['class' => 'form-control due']) }}
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
              </div>
            </div>
          </div>
          <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.new')]) }}
              </div>
            </div>
          </div>
          <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.confirmation')]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-auto mx-auto">
              {{ Form::submit(trans('common.submit'), ['class' => 'btn btn-primary']) }}
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
