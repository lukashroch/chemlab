@extends('app')

@section('title')
  {{ trans('profile.index') }} | {{ $user->name }}
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('profile.info') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#settings" data-toggle="tab" role="tab">{{ trans('profile.settings') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#notifications" data-toggle="tab"
             role="tab">{{ trans('profile.notifications') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#roles" data-toggle="tab" role="tab">{{ trans('user.roles') }}</a>
        </li>
      </ul>
    </div>
    <div class="tab-content" id="user-profile" data-url="{{ route('profile.update') }}">
      <div class="tab-pane active" id="info" role="tabpanel">
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
            <td>{{ link_to_route('profile.password', trans('user.password.change')) }}</td>
          </tr>
          <tr>
            <th>{{ trans('profile.ip') }}</th>
            <td>{{ $user->ip }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="settings" role="tabpanel">
        <div class="card-body">
          <div class="form-group form-row">
            <label class="col-sm-4 col-md-3 col-xl-2 col-form-label">{{ trans('profile.settings.lang') }}</label>
            <div class="col-sm-8 col-md-6 col-lg-4">
              {{ Form::select('lang', ['en' => trans('profile.settings.lang.en'), 'cs' => trans('profile.settings.lang.cs')], $user->settings()->get('lang'), ['class' => 'form-control selectpicker show-tick']) }}
            </div>
          </div>
          <div class="form-group form-row">
            <label class="col-sm-4 col-md-3 col-xl-2 col-form-label">{{ trans('profile.settings.listing') }}</label>
            <div class="col-sm-8 col-md-6 col-lg-4">
              {{ Form::select('listing', ['25' => '25', '50' => '50', '100' => '100'], $user->settings()->get('listing'), ['class' => 'form-control selectpicker show-tick']) }}
            </div>
          </div>
          @permission('nmr-show')
          <div class="form-group form-row">
            <label
                class="col-sm-4 col-md-3 col-xl-2 col-form-label">{{ trans('profile.settings.allow-nmr') }}</label>
            <div class="col-sm-8 col-md-6 col-lg-4">
              {{ Form::select('allow-nmr', ['0' => trans('common.no'), '1' => trans('common.yes')], $user->settings()->get('allow-nmr'), ['class' => 'form-control selectpicker show-tick']) }}
            </div>
          </div>
          @endpermission
        </div>
      </div>
      <div class="tab-pane" id="notifications" role="tabpanel">
        <div class="card-body">
          <h6 class="card-title">{{ trans('profile.notification.title') }}</h6>
          <ul class="list-group list-group-flush">
            @if( $user->settings()->get('allow-nmr'))
              <li class="list-group-item">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="notifications.nmr-uploaded" value=""
                        {{ $user->settings()->get('notifications.nmr-uploaded') ? ' checked' : ''}}>
                    {{ trans('profile.notification.nmr-uploaded') }}
                  </label>
                </div>
              </li>
            @endif
          </ul>
        </div>
      </div>
      <div class="tab-pane" id="roles" role="tabpanel">
        <table class="table table-hover">
          <tbody>
          @forelse ($roles->sortBy('role_name') as $role)
            <tr>
              <td>
                <span class="fas fa-role" aria-hidden="true" title="{{ trans('role.title') }}"></span>
                {{ $role->role_name }} - {{ $role->team_name ?? trans('common.generic') }}
              </td>
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
@endsection
