<div class="modal fade" id="{{ $id }}-modal" aria-labelledby="{{ $id }}-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ trans('chemical.structure') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <iframe class="structure-sketcher" id="ketcher" src="{{ url('vendor/ketcher-v2/ketcher.html') }}"></iframe>
      </div>
      <div class="modal-footer">
        {{ Form::button('<span class="fa fa-' .$id. '-submit" aria-hidden="true"></span> '.trans('common.submit'), ['id' => $id.'-submit', 'class' => 'btn btn-primary']) }}
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-secondary']) }}
      </div>
    </div>
  </div>
</div>