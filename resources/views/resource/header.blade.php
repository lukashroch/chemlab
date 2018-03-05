<div class="card-header">
  <div class="row justify-content-between">
    <div class="col-auto">
      <ul class="nav nav-tabs card-header-tabs" role="tablist">
        {{ $slot }}
      </ul>
    </div>
    <div class="col-auto">
      @includeWhen($module == 'chemical' && (empty($actions) || in_array('show', $actions)), 'chemical.partials.data')
      <div class="btn-group btn-group-sm" role="group" aria-label="actions">
        @foreach ($actions as $action)
          @include('partials.actions.'.$action, ['resource' => $module, 'entry' => $item, 'response' => $action == 'delete' ? 'redirect' : ""])
        @endforeach
      </div>
    </div>
  </div>
</div>