@if((isset($pass) && $pass) || auth()->user()->can($resource.'-edit'))
  <a role="button" class="btn btn-secondary btn-sm" href="{{ route($resource.'.edit', [Str::singular($resource) => $entry->id]) }}"
     title="{{ trans($resource.'.edit') }}">
    <span class="fas fa-fw fa-{{ $resource }}-edit" title="{{ trans($resource.'.edit') }}"></span>
  </a>
@endif
