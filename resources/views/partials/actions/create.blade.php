<a class="btn btn-primary float-right" href="{{ route($resource.'.create') }}"
   title="{{ trans($resource.'.create') }}">
  <span class="fas fa-fw fa-{{ $resource }}-create" title="{{ trans($resource.'.create') }}"></span>
  <span class="d-none d-lg-inline">{{ trans($resource.'.create') }}</span>
</a>