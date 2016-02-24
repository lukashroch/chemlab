<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-6">{{ trans('chemical.structure') }}</div>
          <div class="col-sm-6">
            <div class="pull-right">
              <div class="btn-group btn-group-sm">
                {{ Form::button(trans('chemical.structure.inchikey'), ['id' => 'test', 'class' => 'btn btn-default', 'data-toggle' => 'modal',
                  'data-target' => '#structure-data-modal', 'data-structure' => 'inchikey']) }}
                {{ Form::button(trans('chemical.structure.inchi'), ['class' => 'btn btn-default', 'data-toggle' => 'modal',
                  'data-target' => '#structure-data-modal', 'data-structure' => 'inchi']) }}
                {{ Form::button(trans('chemical.structure.smiles'), ['class' => 'btn btn-default', 'data-toggle' => 'modal',
                  'data-target' => '#structure-data-modal', 'data-structure' => 'smiles']) }}
                {{ Form::button(trans('chemical.structure.sdf'), ['class' => 'btn btn-default', 'data-toggle' => 'modal',
                  'data-target' => '#structure-data-modal', 'data-structure' => 'sdf']) }}
              </div>
              @if ($action == 'edit')
                {{ Form::button(trans('chemical.structure.edit'), ['class' => 'btn btn-primary btn-sm', 'id' => 'structure-sketcher-open', 'data-toggle' => 'modal', 'data-target' => '#structure-sketcher-modal']) }}
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <iframe id="structure-render" src="{{ url('vendor/ketcher/ketcher_render.html') }}"></iframe>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="structure-data-modal" tabindex="-1" role="dialog"
     aria-labelledby="structure-data-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('chemical.structure') }}</h4>
      </div>
      <div class="modal-body">
        <code></code>
      </div>
      <div class="modal-footer">
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-default']) }}
      </div>
    </div>
  </div>
</div>