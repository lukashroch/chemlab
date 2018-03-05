@if(Auth::user()->canHandleRole($role->name))
  <tr data-id="{{ $role->id }}">
    <td>
      <span class="fa fa-role" aria-hidden="true" title="{{ trans('role.title') }}"></span>
      {{ $role->getDisplayNameWithDesc() }}
      {{ $role->pivot ? $role->pivot->team_id : "" }}
      @includeWhen(auth()->user()->hasPermission('role-user-'.$action), 'partials.actions.badge', ['action' => $action])
    </td>
  </tr>
@else
  <tr class="disabled">
    <td>
      <span class="fa fa-role" aria-hidden="true" title="{{ trans('role.title') }}"></span>
      {{ $role->getDisplayNameWithDesc() }}
    </td>
  </tr>
@endif