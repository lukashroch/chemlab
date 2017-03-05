<div class="modal fade" id="{{ $id }}-modal" tabindex="-1" role="dialog"
     aria-labelledby="{{ $id }}-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        {{ Form::button('<span aria-hidden="true">&times;</span>', ['class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) }}
        <h4 class="modal-title">{{ trans('chemical.structure') }}</h4>
      </div>
      <div class="modal-body modal-sketcher">
        <iframe id="structure-sketcher" src="{{ url('vendor/ketcher-v2/ketcher.html') }}"></iframe>
      </div>
      <div class="modal-footer">
        {{ Form::button('<span class="fa fa-' .$id. '-submit" aria-hidden="true"></span> '.trans('common.submit'), ['id' => $id.'-submit', 'class' => 'btn btn-primary']) }}
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-default']) }}
      </div>
    </div>
  </div>
</div>