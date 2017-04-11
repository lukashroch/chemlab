@if(Auth::user()->canHandlePermission($perm->name, $role->name))
  <li class="list-group-item" data-id="{{ $perm->id }}">
    {{ HtmlEx::icon('role.permission', ['name' => $perm->getDisplayNameWithDesc()]) }}
    {{ HtmlEx::icon('common.badge.'.$type) }}
  </li>
@else
  <li class="list-group-item disabled">
    {{ HtmlEx::icon('role.permission', ['name' => $perm->getDisplayNameWithDesc()]) }}
  </li>
@endif