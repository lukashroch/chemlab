@permission($resource.'-edit')
<a role="button" class="btn btn-primary btn-sm float-right" href="{{ route($resource.'.create') }}"
   title="{{ trans($resource.'.create') }}">
  <span class="fa fa-fw fa-{{ $resource }}-create" title="{{ trans($resource.'.create') }}"></span>
  <span class="d-none d-lg-inline">{{ trans($resource.'.create') }}</span>
</a>
@endpermission