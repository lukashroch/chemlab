@extends('app')

@section('title-content')
  {{ trans('user.profile') }} | {{ $user->name }}
@endsection

@section('head-content')
  <li>{{ HtmlEx::icon('user.profile') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-6">
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
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.settings') }}</div>
        <div class="panel-body" id="user-profile-settings">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label">{{ trans('user.lang') }}</label>
              <div class="input-group col-sm-9 col-lg-6">
                <div class="input-group-addon"><span class="fa fa-user-profile-language fa-fw"></span></div>
                {{ Form::select('lang', array('en' => trans('user.lang.en'), 'cs' => trans('user.lang.cs')), $user->lang, array('class' => 'form-control selectpicker show-tick')) }}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">{{ trans('user.listing') }}</label>
              <div class="input-group col-sm-9 col-lg-6">
                <div class="input-group-addon"><span class="fa fa-user-profile-listing fa-fw"></span></div>
                {{ Form::select('listing', array('25' => '25', '50' => '50', '100' => '100'), $user->listing, array('class' => 'form-control selectpicker show-tick')) }}
              </div>
            </div>
          </div>
        </div>
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
              <td>{{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}</td>
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
  </div>
@endsection
