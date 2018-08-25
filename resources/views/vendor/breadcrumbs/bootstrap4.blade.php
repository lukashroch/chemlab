@if (count($breadcrumbs))
  <ol class="breadcrumb my-auto float-right">
    @foreach ($breadcrumbs as $breadcrumb)
      @if ($breadcrumb->url && !$loop->last)
        <li class="breadcrumb-item">
          <a href="{{ $breadcrumb->url }}">
            @if (isset($breadcrumb->icon))
              <span class="{{ $breadcrumb->icon }}" title="{{ $breadcrumb->title }}"></span>
            @else
              {{ $breadcrumb->title }}
            @endif
          </a>
        </li>
      @else
        <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
      @endif
    @endforeach
  </ol>
@endif
