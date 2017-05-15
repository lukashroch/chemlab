@if(Auth::user()->canHandlePermission($perm->name, $role->name))
  <tr data-id="{{ $perm->id }}">
    <td>
      {{ HtmlEx::icon('role.permission', ['name' => $perm->getDisplayNameWithDesc()]) }}
      {{ HtmlEx::icon('common.badge.'.$type) }}
    </td>
  </tr>
@else
  <tr class="disabled">
    <td>{{ HtmlEx::icon('role.permission', ['name' => $perm->getDisplayNameWithDesc()]) }}</td>
  </tr>
@endif