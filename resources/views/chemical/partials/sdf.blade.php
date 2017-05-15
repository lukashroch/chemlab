<div class="btn-group btn-group-sm float-right">
  {{ Form::button(trans('chemical.structure.sdf'), ['class' => 'btn btn-secondary', 'data-toggle' => 'modal',
    'data-target' => '#structure-data-modal', 'data-structure' => 'sdf']) }}
  @if ($action == 'edit')
    {{ HtmlEx::icon('chemical.structure.edit', ['id' => 'structure-sketcher-open', 'class' => 'btn btn-primary',
      'data-toggle' => 'modal', 'data-target' => '#structure-sketcher-modal']) }}
  @endif
</div>

<div class="modal fade" id="structure-data-modal" aria-labelledby="structure-data-modal">
  <div class="modal-dialog" role="document">
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