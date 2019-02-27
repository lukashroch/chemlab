@extends('app')

@section('title', trans('user.registration'))

@section('content')
  <div class="row justify-content-center">
    <div class="col-12" style="max-width: 32rem">
      <div class="card">
        <div class="card-header">
          <h3 class="my-2">{{ trans('common.register') }}</h3>
        </div>
        <div class="card-body">
          {{ Form::open(['route' => 'register', 'method' => 'post']) }}
          <div class="form-group">
            {{ Form::label('name', trans('user.name'), ['class' => 'control-label']) }}
            {{ Form::input('text', 'name', old('name'), ['class' => 'form-control', 'placeholder' => trans('user.name')]) }}
            @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
          </div>
          <div class="form-group">
            {{ Form::label('email', trans('user.email'), ['class' => 'control-label']) }}
            {{ Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => trans('user.email')]) }}
            @includeWhen($errors->has('email'), 'partials.error', ['entry' => 'email'])
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password'), ['class' => 'control-label']) }}
            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('user.password')]) }}
            @includeWhen($errors->has('password'), 'partials.error', ['entry' => 'password'])
          </div>
          <div class="form-group">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'control-label']) }}
            {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('user.password.confirmation')]) }}
            @includeWhen($errors->has('password_confirmation'), 'partials.error', ['entry' => 'password_confirmation'])
          </div>
          <div class="form-group row justify-content-center">
            <div class="col-auto">
              <button type="submit" class="btn btn-lg btn-primary px-5">{{ trans('common.register') }}</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
