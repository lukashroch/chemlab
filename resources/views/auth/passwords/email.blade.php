@extends('app')

@section('title-content')
  {{ trans('user.password.reset') }}
@endsection

@section('head-content')
  <li>{{ trans('user.password.reset') }}</li>
@endsection

@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible"
         role="alert">{{ session('status') }}{{ HtmlEx::icon('common.alert.close') }}</div>
  @endif

  <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
    <div class="card">
      <div class="card-header">{{ trans('user.password.reset')}}</div>
      <div class="card-body">
        {{ Form::open(['url' => '/password/email', 'role' => 'form', 'method' => 'post']) }}
        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
          {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-3 col-form-label']) }}
          <div class="col-sm-9">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
              {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
            </div>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <div class="col-auto">
            {{ Form::button('<span class="fa fa-user-email fa-fw" aria-hidden="true"></span> '.trans('user.password.reset.send'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
          </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection
