<div class="btn-group btn-group-sm float-right">
  <button class="btn btn-secondary" id="structure-data-open" data-toggle="modal"
          data-target="#structure-data-modal" data-structure="sdf">
    <span class="fa fa-chemical-structure-sdf"></span>
    <span class="d-none d-md-inline-flex">{{ trans('chemical.structure.sdf') }}</span>
  </button>
  @if ($action == 'edit')
    <button class="btn btn-primary" id="structure-sketcher-open" data-toggle="modal"
            data-target="#structure-sketcher-modal">
      <span class="fa fa-chemical-structure-edit"></span>
      <span class="d-none d-md-inline-flex">{{ trans('chemical.structure.edit') }}</span>
    </button>
  @endif
</div>

<div class="modal fade" id="structure-data-modal" aria-labelledby="structure-data-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ trans('chemical.structure') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <code></code>
      </div>
      <div class="modal-footer">
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-secondary']) }}
      </div>
    </div>
  </div>
</div>