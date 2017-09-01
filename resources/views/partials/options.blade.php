<div class="btn-group">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownOptionsButton" data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false">
    <span class="fa fa-nav-options" aria-hidden="true"></span>
    <span class="d-none d-lg-inline">{{ trans('common.options') }}</span>
  </button>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownOptionsButton" id="action-menu">
    @if(($module == "chemical" && auth()->user()->can('chemical-edit')) || auth()->user()->can($module.'-delete'))
      @if($module == "chemical" && auth()->user()->can('chemical-edit'))
        <a class="dropdown-item move" href="#" data-action="move" data-toggle="modal"
           data-target="#chemical-item-move-modal">
          <span class="fa fa-fw fa-exchange" aria-hidden="true" title="{{ trans('chemicals-item.move') }}"></span>
          {{ trans('chemical-item.move') }}
        </a>
      @endif
      @permission($module.'-delete')
      <a class="dropdown-item delete" href="#"
         data-url="{{ route($module == 'chemical' ? 'chemical-item.delete' : $module.'.delete') }}"
         data-action="multi-delete" data-confirm="{{ trans('common.action.multi.delete.confirm') }}"
         data-response="dt">
        <span class="fa fa-fw fa-delete" aria-hidden="true" title="{{ trans('common.action.multi.delete') }}"></span>
        {{ trans('common.action.multi.delete') }}
      </a>
      @endpermission
      <div class="dropdown-divider"></div>
    @endif
    <a class="dropdown-item export" href="#" data-url="{{ $route }}" data-action="print" target="_blank">
      <span class="fa fa-fw fa-print" aria-hidden="true" title="{{ trans('common.export.print') }}"></span>
      {{ trans('common.export.print') }}
    </a>

    <a class="dropdown-item export" href="#" data-url="{{ $route }}" data-action="csv">
      <span class="fa fa-fw fa-file-text-o" aria-hidden="true"
            title="{{ trans('common.export.csv') }}"></span>
      {{ trans('common.export.csv') }}
    </a>
    <a class="dropdown-item export" href="#" data-url="{{ $route }}" data-action="excel">
      <span class="fa fa-fw fa-file-excel-o" aria-hidden="true"
            title="{{ trans('common.export.excel') }}"></span>
      {{ trans('common.export.excel') }}
    </a>
    {{-- <a class="dropdown-item export" href="#" data-url="{{ $route }}" data-action="pdf">
        <span class="fa fa-fw fa-file-pdf-o" aria-hidden="true" title="{{ trans('common.export.pdf') }}"></span>
        {{ trans('common.export.pdf') }}
      </a> --}}
  </div>
</div>