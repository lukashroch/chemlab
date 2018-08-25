<div class="col-12 col-sm d-inline-flex mb-2 mb-sm-0">
  <button type="button" class="btn btn-warning mr-2 search-clear">
    <span class="fas fa-times" title="{{ trans('common.search.clear') }}"></span>
  </button>
  {{ Form::label('s', trans('common.search'), ['class' => 'sr-only']) }}
  {{ Form::input('text', 's', request()->get('s'), ['class' => 'form-control typeahead', 'placeholder' => trans('common.search')]) }}
</div>