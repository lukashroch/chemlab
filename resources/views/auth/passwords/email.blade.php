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
          {{ Form::open(['route' => 'password.email', 'method' => 'post']) }}
          <div class="form-group">
            {{ Form::label('email', trans('users.email'), ['class' => 'col-form-label sr-only']) }}
            <div class="input-group">
              {{ Form::input('email', 'email', old('email'), ['id' => 'email', 'class' => 'form-control',  'placeholder' => trans('user.email') ]) }}
              <div class="input-group-append">
                <span class="input-group-text"><span class="far fa-fw fa-envelope"></span></span>
              </div>
            </div>
            @includeWhen($errors->has('email'), 'partials.error', ['entry' => 'email'])
          </div>
          <div class="form-group row justify-content-center mt-4">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary px-4">
                <span class="fas fa-fw fa-user-email" aria-hidden="true"></span>
                {{ trans('user.password.reset.send') }}
              </button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
