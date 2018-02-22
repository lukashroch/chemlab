<div class="row">
  <div class="col">
    <ol class="breadcrumb">
      @if ($module == 'chemical' && $action == 'index')
        <li class="breadcrumb-item">
          {{ Form::button('<span class="fa fa-store-index"></span>', ['class' => 'btn btn-sm btn-primary btn-store-view', 'data-toggle' => 'modal', 'data-target' => '#store-tree-modal']) }}
        </li>
        <li class="breadcrumb-item no-divider">{{ HtmlEx::icon($module . ".index") }}</li>
      @else
        <li class="breadcrumb-item">{{ HtmlEx::icon($module . ".index") }}</li>
      @endif

      {{ $slot }}
    </ol>
    {{ HtmlEx::icon($module.'.create') }}
  </div>

</div>
