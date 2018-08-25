<div class="card-header">
  <ul class="nav nav-tabs card-header-tabs" role="tablist">
    {{ $slot }}
  </ul>
  <div class="card-tools">
    @includeWhen($resource == 'chemical' && (empty($actions) || in_array('show', $actions)), 'chemical.partials.data')
    <div class="btn-group btn-group-sm" role="group" aria-label="actions">
      @foreach ($actions as $action)
        @include('partials.actions.'.$action, ['resource' => $resource, 'entry' => $item, 'response' => $action == 'delete' ? 'redirect' : ""])
      @endforeach
    </div>
  </div>
</div>
