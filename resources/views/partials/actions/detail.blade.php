@if (!auth()->user()->hasPermission($resource.'-show') || $resource == "admin.dbbackup")
  <a href="{{ route($resource.'.show', ['id' => $entry->id]) }}"
     title="{{ trans('common.action.detail') }}">{{ Str::limit($entry->name, 50) }}</a>
@endif