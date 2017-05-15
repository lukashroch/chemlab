<div class="modal fade" id="chemical-msds-modal" aria-labelledby="chemical-msds-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ trans('msds.symbol_title') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <table class="table">
        @foreach($chemical->symbol as $item)
          <tr>@include('chemical.partials.ghs', ['item' => $item])</tr>
        @endforeach
      </table>
      <div class="modal-footer">
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-secondary']) }}
      </div>
    </div>
  </div>
</div>