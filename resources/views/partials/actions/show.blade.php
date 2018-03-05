@if ((isset($pass) && $pass) || auth()->user()->hasPermission($resource.'-show') || $resource == "admin.dbbackup")
  <a role="button" class="btn btn-sm btn-secondary" href="{{ route($resource.'.show', ['id' => $entry->id]) }}"
     title="{{ trans($resource.'.show') }}">
    <span class="fa fa-fw fa-{{ $resource }}-show" title="{{ trans($resource.'.show') }}"></span>
  </a>
@endif