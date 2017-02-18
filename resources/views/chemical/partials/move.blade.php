<div class="modal fade" id="chemical-item-move-modal" tabindex="-1" role="dialog"
     aria-labelledby="chemical-item-move-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('chemical-item.move.title') }}</h4>
      </div>
      <div class="modal-body">
        <blockquote>{{ trans('chemical-item.move.number') }} <span></span></blockquote>
        {{ Form::open(['role' => 'form', 'route' => 'chemical-item.move', 'id' => 'move', 'class' => 'form-horizontal']) }}
        <div class="form-group">
          {{ Form::label('store_id', trans('store.title'), ['class' => 'col-sm-2 control-label']) }}
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
              {{ Form::select('store_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        {{ HtmlEx::icon('common.submit') }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>