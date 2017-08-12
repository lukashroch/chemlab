<div class="col-sm-12 col-lg-6">
  <div class="input-group">
  <span class="input-group-btn">
    <button type="button" class="btn btn-secondary" id="search-clear">
      <span class="fa fa-rotate-right" title="{{ trans('common.search.clear') }}" aria-hidden="true"></span>
    </button>
  </span>
    {{ Form::label('s', trans('common.search'), ['class' => 'sr-only']) }}
    {{ Form::input('text', 's', Input::get('s'), ['class' => 'form-control typeahead', 'placeholder' => trans('common.search')]) }}
    <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
  </div>
</div>