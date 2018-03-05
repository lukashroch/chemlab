@if(Auth::user()->canHandlePermission($permission->name, $role->name))
  <tr data-id="{{ $permission->id }}">
    <td>
      <span class="fa fa-permission" aria-hidden="true" title="{{ trans('permission.title') }}"></span>
      {{ $permission->getDisplayNameWithDesc() }}
      @includeWhen(auth()->user()->hasPermission('permission-role-'.$action), 'partials.actions.badge', ['action' => $action])
    </td>
  </tr>
@else
  <tr class="disabled">
    <td>
      <span class="fa fa-permission" aria-hidden="true" title="{{ trans('permission.title') }}"></span>
      {{ $permission->getDisplayNameWithDesc() }}
    </td>
  </tr>
@endif