<tr data-id="{{ $user->id }}">
  <td>
    <span class="fa fa-user" aria-hidden="true" title="{{ trans('user.title') }}"></span>
    {{ $user->name }}
    @includeWhen(auth()->user()->hasPermission('team-user-'.$action), 'partials.actions.badge', ['action' => $action])
  </td>
</tr>