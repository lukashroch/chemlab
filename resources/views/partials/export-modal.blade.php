<div class="modal fade" id="export-modal" aria-labelledby="export-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ trans('common.export') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('common.close') }}">
          <span class="fas fa-times" aria-label="{{ trans('common.close') }}"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group form-row">
          @foreach($columns as $column)
            <div class="form-check col-6 mb-2">
              <div class="custom-control custom-checkbox">
                {{ Form::checkbox($column['name'], '1', true, ['id' => Str::camel($column['name']), 'class' => 'custom-control-input']) }}
                {{ Form::label(Str::camel($column['name']), $column['title'], ['class' => 'custom-control-label']) }}
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <div>
          <a class="btn btn-primary export" href="#" data-url="{{ route($resource.'.index') }}" data-action="print"
             target="_blank">
            <span class="fas fa-print" title="{{ trans('common.export.print') }}"></span>
            {{ trans('common.export.print') }}
          </a>
          <a class="btn btn-primary export" href="#" data-url="{{ route($resource.'.index') }}" data-action="csv"
             target="_blank">
            <span class="fas fa-file-alt" title="{{ trans('common.export.csv') }}"></span>
            {{ trans('common.export.csv') }}
          </a>
          <a class="btn btn-primary export" href="#" data-url="{{ route($resource.'.index') }}" data-action="excel"
             target="_blank">
            <span class="fas fa-file-excel" title="{{ trans('common.export.excel') }}"></span>
            {{ trans('common.export.excel') }}
          </a>
          <a class="btn btn-primary export disabled" href="#" data-url="{{ route($resource.'.index') }}"
             data-action="pdf" target="_blank">
            <span class="fas fa-file-pdf" title="{{ trans('common.export.pdf') }}"></span>
            {{ trans('common.export.pdf') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
