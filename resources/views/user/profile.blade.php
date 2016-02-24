@extends('app')

@section('title-content')
  {{ trans('user.profile') }} | {{ $user->name }}
@endsection

@section('head-content')
  {{ HtmlEx::icon('user.profile') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.profile') }}</div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('user.name') }}</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('user.email') }}</th>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <th>{{ trans('user.password') }}</th>
            <td>{{ link_to_route('user.password', trans('user.password.change')) }}</td>
          </tr>
          <tr>
            <th>{{ trans('user.ip') }}</th>
            <td>{{ $user->ip }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.roles') }}</div>
        <table class="table table-hover">
          <tbody>
          @forelse ($user->roles->sortBy('display_name') as $role)
            <tr>
              <td>{{ HtmlEx::icon('user.role', null, $role->getDisplayNameWithDesc()) }}</td>
            </tr>
          @empty
            <tr>
              <td>{{ trans('user.roles.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.settings') }}</div>
        <div class="panel-body" id="user-profile-settings">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-xs-4 col-sm-3 control-label">{{ trans('user.lang') }}</label>
              <div class="input-group col-xs-3">
                <div class="input-group-addon"><span class="fa fa-user-profile-language fa-fw"></span></div>
                {{ Form::select('lang', array('en' => trans('user.lang.en'), 'cs' => trans('user.lang.cs')), $user->lang, array('class' => 'form-control')) }}
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-4 col-sm-3 control-label">{{ trans('user.listing') }}</label>
              <div class="input-group col-xs-3">
                <div class="input-group-addon"><span class="fa fa-user-profile-listing fa-fw"></span></div>
                <div class="form-control">
                  {{ Form::radio('listing', 20, $user->listing == 20, array('class' => 'radio-inline')) }}<label
                          class="control-label inline"> 20 </label>
                  {{ Form::radio('listing', 30, $user->listing == 30, array('class' => 'radio-inline')) }}<label
                          class="control-label inline"> 30 </label>
                  {{ Form::radio('listing', 50, $user->listing == 50, array('class' => 'radio-inline')) }}<label
                          class="control-label inline"> 50 </label>
                  {{ Form::radio('listing', 100, $user->listing == 100, array('class' => 'radio-inline')) }}<label
                          class="control-label inline"> 100 </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
