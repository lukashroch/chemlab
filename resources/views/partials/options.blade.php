<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
    <span class="fa fa-nav-options" aria-hidden="true"></span>
    <span class="hidden-xs hidden-sm">{{ trans('common.options') }}
      <span class="caret"></span></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-left" role="menu" id="action-menu">
    @if(($module == "chemical" && Entrust::can('chemical-edit')) || Entrust::can($module.'-delete'))
      @if($module == "chemical" && Entrust::can('chemical-edit'))
        <li>
          <a class="move" href="#" data-action="move" data-toggle="modal" data-target="#chemical-item-move-modal">
            <span class="fa fa-fw fa-exchange" aria-hidden="true" title="{{ trans('chemicals-item.move') }}"></span>
            {{ trans('chemical-item.move') }}
          </a>
        </li>
      @endif
      @permission($module.'-delete')
      <li>
        <a class="delete" href="#"
           data-url="{{ route($module == 'chemical' ? 'chemical-item.delete' : $module.'.delete') }}"
           data-action="multi-delete" data-confirm="{{ trans('common.action.multi.delete.confirm') }}"
           data-response="dt">
          <span class="fa fa-fw fa-delete" aria-hidden="true" title="{{ trans('common.action.multi.delete') }}"></span>
          {{ trans('common.action.multi.delete') }}
        </a>
      </li>
      @endpermission
      <li role="separator" class="divider"></li>
    @endif
    <li>
      <a class="export" href="#" data-url="{{ $route }}" data-action="print" target="_blank">
        <span class="fa fa-fw fa-print" aria-hidden="true" title="{{ trans('common.export.print') }}"></span>
        {{ trans('common.export.print') }}
      </a>
    </li>
    <li>
      <a class="export" href="#" data-url="{{ $route }}" data-action="csv">
    <span class="fa fa-fw fa-file-text-o" aria-hidden="true"
          title="{{ trans('common.export.csv') }}"></span>
        {{ trans('common.export.csv') }}
      </a>
    </li>
    <li>
      <a class="export" href="#" data-url="{{ $route }}" data-action="excel">
    <span class="fa fa-fw fa-file-excel-o" aria-hidden="true"
          title="{{ trans('common.export.excel') }}"></span>
        {{ trans('common.export.excel') }}
      </a>
    </li>
    {{-- <li>
      <a class="export" href="#" data-url="{{ $route }}" data-action="pdf">
        <span class="fa fa-fw fa-file-pdf-o" aria-hidden="true" title="{{ trans('common.export.pdf') }}"></span>
        {{ trans('common.export.pdf') }}
      </a>
    </li> --}}
  </ul>
</div>