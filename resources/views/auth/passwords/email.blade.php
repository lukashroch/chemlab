@extends('app')

@section('title-content')
  {{ trans('user.password.reset') }}
@endsection

@section('head-content')
  {{ trans('user.password.reset') }}
@endsection

@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible"
         role="alert">{{ session('status') }}{{ HtmlEx::icon('common.alert.close') }}</div>
  @endif

  <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <div class="panel panel-default">
      <div class="panel-heading">{{ trans('user.password.reset')}}</div>
      <div class="panel-body">
        {{ Form::open(['url' => '/password/email', 'role' => 'form', 'method' => 'post', 'class' => 'form-horizontal']) }}
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          {{ Form::label('email', trans('user.email'), ['class' => 'col-sm-2 control-label']) }}
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-user-email fa-fw"></span></div>
              {{ Form::input('email', 'email', null, ['class' => 'form-control due', 'placeholder' => trans('user.email')]) }}
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit(trans('user.password.reset.send'), ['class' => 'btn btn-primary']) }}
          </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection
