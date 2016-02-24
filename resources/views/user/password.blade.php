@extends('app')

@section('title-content')
  {{ trans('user.password.change') }}
@endsection

@section('head-content')
  {{ HtmlEx::icon('user.profile') }}&nbsp;&raquo;&nbsp;{{ trans('user.password.change') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.password.change') }}</div>
        <div class="panel-body">
          {{ Form::open(['url' => 'user/password', 'method' => 'patch', 'class' => 'form-horizontal']) }}
          <div class="form-group">
            {{ Form::label('password_current', trans('user.password.current'), ['class' => 'col-sm-4 control-label']) }}
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password_current', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.current')]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('password', trans('user.password.new'), ['class' => 'col-sm-4 control-label']) }}
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.new')]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('password_confirmation', trans('user.password.confirmation'), ['class' => 'col-sm-4 control-label']) }}
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-password fa-fw"></span></div>
                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control due', 'placeholder' => trans('user.password.confirmation')]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
