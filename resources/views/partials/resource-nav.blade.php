<div class="row">
  <div class="col-sm-12">
    <ol class="breadcrumb">
      @if ($module == 'chemical' && $action == 'index')
        <li class="breadcrumb-item">
          {{ Form::button('<span class="fa fa-store-index"></span>', ['class' => 'btn btn-sm btn-primary btn-store-view', 'data-toggle' => 'modal', 'data-target' => '#store-tree-modal']) }}
        </li>
      @endif

      <li class="breadcrumb-item">{{ HtmlEx::icon($module . ".index") }}</li>
      {{ $slot }}

      {{ HtmlEx::icon($module.'.create') }}
    </ol>
  </div>
</div>