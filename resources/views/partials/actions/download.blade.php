@if(auth()->user()->can($resource.'-show'))
  <a class="btn btn-sm btn-primary" href="{{ route($resource.'.download', [Str::singular($resource) => $entry->{$key ?? 'id'}]) }}"
     title="{{ trans('common.action.download') }}" target="_blank">
    <span class="fas fa-fw fa-download" title="{{ trans('common.action.download') }}"></span>
  </a>
@endif
