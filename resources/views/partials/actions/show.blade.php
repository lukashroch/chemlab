@if ((isset($pass) && $pass) || auth()->user()->can($resource.'-show'))
  <a role="button" class="btn btn-sm btn-secondary" href="{{ route($resource.'.show', ['id' => $entry->{$key ?? 'id'}]) }}"
     title="{{ trans($resource.'.show') }}">
    <span class="fas fa-fw fa-{{ $resource }}-show" title="{{ trans($resource.'.show') }}"></span>
  </a>
@endif