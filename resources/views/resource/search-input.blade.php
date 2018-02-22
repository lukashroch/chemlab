<div class="col-sm-12 col-lg-6">
  <div class="input-group">
    <div class="input-group-prepend">
        <button type="button" class="btn btn-secondary" id="search-clear">
          <span class="fa fa-rotate-right" title="{{ trans('common.search.clear') }}" aria-hidden="true"></span>
        </button>
    </div>
    {{ Form::label('s', trans('common.search'), ['class' => 'sr-only']) }}
    {{ Form::input('text', 's', request()->get('s'), ['class' => 'form-control typeahead', 'placeholder' => trans('common.search')]) }}
    <div class="input-group-append">
      {{ HtmlEx::icon('common.search') }}
    </div>
  </div>
</div>