<li class="nav-item">
  <a class="nav-link" href="{{ route($type) }}">
    <span class="fa fa-fw fa-{{ str_replace('.', '-', $type) }}" aria-hidden="true"></span> {{ trans($type) }}
  </a>
</li>