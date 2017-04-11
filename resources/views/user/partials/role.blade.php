@if(Auth::user()->canHandleRole($role->name))
  <li class="list-group-item" data-id="{{ $role->id }}">
    {{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}
    {{ HtmlEx::icon('common.badge.'.$type) }}
  </li>
@else
  <li class="list-group-item disabled">
    {{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}
  </li>
@endif