<div class="col-auto">
  <button type="button" class="btn btn-warning" id="search-clear">
    <span class="fa fa-rotate-right" title="{{ trans('common.search.clear') }}" aria-hidden="true"></span>
  </button>
</div>
<div class="col-sm-12 col-lg-6">
  <div class="input-group">
    <div class="input-group-prepend">
    </div>
    {{ Form::label('s', trans('common.search'), ['class' => 'sr-only']) }}
    {{ Form::input('text', 's', request()->get('s'), ['class' => 'form-control typeahead', 'placeholder' => trans('common.search')]) }}
  </div>
</div>