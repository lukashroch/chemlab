@extends('app')

@section('title-content')
  {{ trans('user.password.change') }}
@endsection

@section('content')
  @component('partials.nav')
    <li class="breadcrumb-item">@include('partials.actions.index', ['resource' => 'profile'])</li>
    <li class="breadcrumb-item">{{ trans('user.password.change') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">{{ trans('user.password.change') }}</h6>
        </div>
        <div class="card-body">
          {{ Form::open(['url' => 'user/password', 'method' => 'patch']) }}
          <div class="form-group form-row">
            {{ Form::label('password_current', trans('user.password.current'), ['class' => 'col-md-4 col-form-label d-none d-md-inline-flex']) }}
            <div class="col-sm-12 col-md-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fa fa-user-password fa-fw"></span>
                  </div>
                </div>
                {{ Form::input('password', 'password_current', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.current')]) }}
              </div>
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'col-md-4 col-form-label d-none d-md-inline-flex']) }}
            <div class="col-sm-12 col-md-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fa fa-user-password fa-fw"></span>
                  </div>
                </div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.new')]) }}
              </div>
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'col-md-4 col-form-label d-none d-md-inline-flex']) }}
            <div class="col-sm-12 col-md-8">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fa fa-user-password fa-fw"></span>
                  </div>
                </div>
                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.confirmation')]) }}
              </div>
            </div>
          </div>
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">
              @include('partials.actions.save')
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
