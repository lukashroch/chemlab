@if(Auth::user()->canHandleRole($role->name))
  <tr data-id="{{ $role->id }}">
    <td>
      {{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}
      {{ HtmlEx::icon('common.badge.'.$type) }}
    </td>
  </tr>
@else
  <tr class="disabled">
    <td>{{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}</td>
  </tr>
@endif