@extends('app')

@section('title', trans('user.password.change'))

@section('content')
  <div class="row justify-content-center">
    <div class="col-12" style="max-width: 32rem">
      <div class="card card-item">
        <div class="card-header">
          <h3 class="my-2">{{ trans('user.password.change') }}</h3>
        </div>
        <div class="card-body p-4">
          {{ Form::open(['route' => 'profile.password', 'method' => 'patch']) }}
          <div class="form-group">
            {{ Form::label('password_current', trans('user.password.current'), ['class' => 'fw6']) }}
            {{ Form::input('password', 'password_current', null, ['class' => 'form-control']) }}
            @includeWhen($errors->has('password_current'), 'partials.error', ['entry' => 'password_current'])
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'fw6']) }}
            {{ Form::input('password', 'password', null, ['class' => 'form-control']) }}
            @includeWhen($errors->has('password'), 'partials.error', ['entry' => 'password'])
          </div>
          <div class="form-group">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'fw6']) }}
            {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) }}
            @includeWhen($errors->has('password_confirmation'), 'partials.error', ['entry' => 'password_confirmation'])
          </div>
          <div class="form-group form-row justify-content-center mt-4">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary px-4">{{ trans('common.submit') }}</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
