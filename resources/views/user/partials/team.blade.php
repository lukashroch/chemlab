<tr data-id="{{ $team->id }}">
  <td>
    <span class="fa fa-team" aria-hidden="true" title="{{ trans('team.title') }}"></span>
    {{ $team->display_name }}
    @includeWhen(auth()->user()->hasPermission('team-user-'.$action), 'partials.actions.badge', ['action' => $action])
  </td>
</tr>