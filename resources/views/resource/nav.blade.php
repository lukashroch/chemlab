<div class="card bg-light mb-4">
  <div class="card-body row px-3 py-2">
    @if ($module == 'chemical' && $action == 'index')
      <div class="col-auto pr-0">
        <button class="btn btn-primary btn-store-view" data-toggle="modal" data-target="#store-tree-modal">
          <span class="fas fa-store-index"></span>
        </button>
      </div>
    @endif
    <div class="col">
      <ol class="breadcrumb bg-light">
        <li class="breadcrumb-item no-divider">
          @include('partials.actions.index', ['resource' => $module])
        </li>
        {{ $slot }}
      </ol>
    </div>
    <div class="col-auto">
      @includeWhen(isset($module), 'partials.actions.create', ['resource' => $module])
    </div>
  </div>
</div>
