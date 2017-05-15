<div class="card-header form-inline">
  <div class="col">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
      {{ $slot }}
    </ul>
  </div>
  <div class="col">
    <div class="float-right">
      @includeWhen($module == 'chemical' && in_array('show', $actions), 'chemical.partials.data')
      <div class="btn-group btn-group-sm" role="group" aria-label="actions">
        @foreach ($actions as $action)
          {{ HtmlEx::icon($module.'.'.$action, $action == 'delete' ?
          ['id' => $item->id, 'name' => $item->name, 'response' => 'redirect'] : ['id' => $item->id]) }}
        @endforeach
      </div>
    </div>
  </div>
</div>