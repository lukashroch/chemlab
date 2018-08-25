@extends('app')

@section('title', trans('user.password.reset'))

@section('content')
  <div class="row justify-content-center">
    <div class="col-12" style="max-width: 32rem">
      <div class="card card-item">
        <div class="card-header">
          <h3 class="my-2">{{ trans('user.password.reset') }}</h3>
        </div>
        <div class="card-body p-4">
          {{ Form::open(['route' => 'password.request', 'method' => 'post']) }}
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="form-group">
            {{ Form::label('email', trans('user.email'), ['class' => 'fw6']) }}
            {{ Form::input('email', 'email', $email ?? old('email'), ['id' => 'email', 'class' => 'form-control', 'placeholder' => trans('user.email')]) }}
            @includeWhen($errors->has('email'), 'partials.error', ['entry' => 'email'])
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'fw6']) }}
            {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => trans('user.password.new')]) }}
            @includeWhen($errors->has('password'), 'partials.error', ['entry' => 'password'])
          </div>
          <div class="form-group">
            {{ Form::label('password-confirm', trans('user.password.confirmation'), ['class' => 'fw6']) }}
            {{ Form::input('password', 'password_confirmation', null, ['id' => 'password-confirm', 'class' => 'form-control', 'placeholder' => trans('user.password.confirmation')]) }}
            @includeWhen($errors->has('password_confirmation'), 'partials.error', ['entry' => 'password_confirmation'])
          </div>
          <div class="form-group row justify-content-center mt-4">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">{{ trans('user.password.reset') }}</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
