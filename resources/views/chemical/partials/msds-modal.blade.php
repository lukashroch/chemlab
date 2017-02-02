<div class="modal fade" id="chemical-msds-modal" tabindex="-1" role="dialog"
     aria-labelledby="chemical-msds-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">{{ trans('msds.symbol_title') }}</h4>
      </div>
      <table class="table">
        @foreach($chemical->symbol as $item)
          <tr>@include('chemical.partials.ghs', ['item' => $item])</tr>
        @endforeach
      </table>
      <div class="modal-footer">
        {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-default']) }}
      </div>
    </div>
  </div>
</div>