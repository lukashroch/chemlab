<div class="card bg-light mb-4">
  <div class="card-body row p-3">
    @if ($module == 'chemical' && $action == 'index')
      <div class="col-auto pr-0">
        {{ Form::button('<span class="fa fa-store-index"></span>', ['class' => 'btn btn-sm btn-primary btn-store-view', 'data-toggle' => 'modal', 'data-target' => '#store-tree-modal']) }}
      </div>
    @endif
    <div class="col">
      <ol class="breadcrumb bg-light">
        <li class="breadcrumb-item no-divider">{{ HtmlEx::icon($module . ".index") }}</li>
        {{ $slot }}
      </ol>
    </div>
    <div class="col-auto">
      {{ HtmlEx::icon($module.'.create') }}
    </div>

  </div>
</div>
