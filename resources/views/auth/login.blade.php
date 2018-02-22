@extends('app')

@section('title-content')
  {{ trans('user.log.in') }}
@endsection

@section('head-content')
  <li>{{ trans('user.log.in')}}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
      <div class="card">
        <h6 class="card-header">{{ trans('user.log.in')}}</h6>
        <div class="card-body">
          {{ Form::open(['url' => '/login', 'role' => 'form', 'method' => 'post']) }}
          <div class="form-group form-row{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><span class="fa fa-user-email fa-fw"></span></div>
                </div>
                {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
              </div>
            </div>
          </div>
          <div class="form-group form-row{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::label('password', trans('user.password'), ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><span class="fa fa-user-password fa-fw"></span></div>
                </div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password')]) }}
              </div>
            </div>
          </div>
          <div class="form-group form-row justify-content-end">
            <div class="col-sm-9">
              <div class="form-check">
                <label class="form-check-label" for="remember">
                  {{ Form::input('checkbox', 'remember', null, ['class' => 'form-check-input']) }} {{ trans('user.remember') }}
                </label>
              </div>
            </div>
          </div>
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">
              {{ Form::button('<span class="fa fa-user-log-in" aria-hidden="true"></span> '.trans('user.log.in'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
          </div>
          {{ Form::close() }}
        </div>
        <div class="card-footer">
          <div class="col-auto float-right">{{ link_to('password/reset', trans('user.password.forgot')) }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
