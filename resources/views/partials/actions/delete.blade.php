@if ((isset($pass) && $pass) || auth()->user()->can($resource == 'chemical-item' ? 'chemical-delete' : $resource.'-delete',
$entry->store ? $entry->store->team_id : null))
  <button class="btn btn-danger btn-sm delete"
          data-url="{{ route($resource.'.delete', ['id' => $entry->{$key ?? 'id'}]) }}"
          data-confirm="{{ trans('common.action.delete.confirm', ['name' => $entry->name ?: ' selected item']) }}"
          data-response="{{ $response }}" title="{{ trans($resource.'.delete') }}">
    <span class="fas fa-fw fa-{{ $resource }}-delete" title="{{ trans($resource.'.delete') }}"></span>
  </button>
@endif
