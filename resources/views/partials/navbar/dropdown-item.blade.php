<a class="dropdown-item" href="{{ route($type) }}">
  <span class="fa fa-{{ str_replace('.', '-', $type) }}" aria-hidden="true"></span> {{ trans($type) }}
</a>