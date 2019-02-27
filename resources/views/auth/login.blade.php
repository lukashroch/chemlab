@extends('app')

@section('title', trans('user.log.in'))

@section('content')
  <div class="row justify-content-center">
    <div class="col-12" style="max-width: 32rem">
      <div class="card">
        <div class="card-header">
          <h3 class="my-2">{{ trans('common.login') }}</h3>
        </div>
        <div class="card-body p-4">
          {{ Form::open(['route' => 'login', 'method' => 'post']) }}
          <div class="form-group">
            {{ Form::label('email', trans('user.email'), ['class' => 'col-form-label fw6']) }}
            {{ Form::input('email', 'email', old('email'), ['id' => 'email', 'class' => 'form-control']) }}
            @includeWhen($errors->has('email'), 'partials.error', ['entry' => 'email'])
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password'), ['class' => 'col-form-label fw6']) }}
            {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control']) }}
            @includeWhen($errors->has('password'), 'partials.error', ['entry' => 'password'])
          </div>
          <div class="form-group row justify-content-between align-items-center mb-4">
            <div class="col-auto">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember"
                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">{{ trans('user.remember') }}</label>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn-link" href="{{ route('password.request') }}">{{ trans('user.password.forgot') }}</a>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <div class="col-auto">
              <button type="submit" class="btn btn-lg btn-primary px-5">{{ trans('common.login') }}</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
