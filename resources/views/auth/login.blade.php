@extends('app')

@section('title-content')
  {{ trans('user.log.in') }}
@endsection

@section('head-content')
  <li>{{ trans('user.log.in')}}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12 col-md-8 col-lg-6 mx-auto">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">{{ trans('user.log.in')}}</h6>
        </div>
        <div class="card-body">
          {{ Form::open(['url' => '/login', 'role' => 'form', 'method' => 'post']) }}
          <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-md-2 col-form-label hidden-sm-down']) }}
            <div class="col-md-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
              </div>
            </div>
          </div>
          <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::label('password', trans('user.password'), ['class' => 'col-sm-2 col-form-label hidden-sm-down']) }}
            <div class="col-md-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password')]) }}
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-10 push-md-2">
              <div class="form-check">
                <label class="form-check-label" for="remember">
                  {{ Form::input('checkbox', 'remember', null, ['class' => 'form-check-input']) }} {{ trans('user.remember') }}
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-auto mx-auto">
              {{ Form::button('<span class="fa fa-user-log-in" aria-hidden="true"></span> '.trans('user.log.in'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
          </div>
          {{ Form::close() }}
        </div>
        <div class="card-footer">
          <div class="col-sm-auto float-right">{{ link_to('password/reset', trans('user.password.forgot')) }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
