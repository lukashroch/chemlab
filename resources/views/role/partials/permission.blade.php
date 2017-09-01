@if(Auth::user()->canHandlePermission($permission->name, $role->name))
  <tr data-id="{{ $permission->id }}">
    <td>
      {{ HtmlEx::icon('role.permission', ['name' => $permission->getDisplayNameWithDesc()]) }}
      {{ HtmlEx::icon('common.badge.'.$type) }}
    </td>
  </tr>
@else
  <tr class="disabled">
    <td>{{ HtmlEx::icon('role.permission', ['name' => $permission->getDisplayNameWithDesc()]) }}</td>
  </tr>
@endif