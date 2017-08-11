<div class="row">
  <div class="col-sm-12">
    <div class="collapse" id="search-advanced">
      <div class="form-group form-group-sm row">
        <div class="col-sm-8 push-sm-4 col-md-5 push-md-1 col-lg-4 push-lg-2">
        <div class="form-check">
          <label for="group">
            {{ Form::checkbox('group', 'group', true) }}
            {{ trans('chemical.search.group') }}
          </label>
        </div>
        </div>
        <div class="form-check col-sm-8 push-sm-4 col-md-5 push-md-1 col-lg-4 push-lg-2">
          <label for="recent">
            {{ Form::checkbox('recent', 'recent', false) }}
            {{ trans('chemical.search.recent') }}
          </label>
        </div>
      </div>
      <div class="form-group form-group-sm row">
        <label class="col-sm-4 col-lg-2 col-form-label">{{ trans('chemical.chemspider') }}</label>
        <div class="col-sm-8 col-lg-4">
          {{ Form::input('text', 'chemspider', Input::get('chemspider'), ['class' => 'form-control', 'placeholder' => trans('chemical.chemspider')]) }}
        </div>
        <label class="col-sm-4 col-lg-2 col-form-label">{{ trans('chemical.pubchem') }}</label>
        <div class="col-sm-8 col-lg-4">
          {{ Form::input('text', 'pubchem', Input::get('pubchem'), ['class' => 'form-control', 'placeholder' => trans('chemical.pubchem')]) }}
        </div>
      </div>
      <div class="form-group form-group-sm row">
        <label class="col-sm-4 col-lg-2 col-form-label">{{ trans('chemical.formula') }}</label>
        <div class="col-sm-8 col-lg-4">
          {{ Form::input('text', 'formula', Input::get('formula'), ['class' => 'form-control', 'placeholder' => trans('chemical.formula')]) }}
        </div>
        <label class="col-sm-4 col-lg-2 col-form-label">{{ trans('chemical.structure.inchikey') }}</label>
        <div class="col-sm-8 col-lg-4">
          <div class="input-group">
            {{ Form::input('text', 'inchikey', Input::get('inchikey'), ['class' => 'form-control']) }}
            <span class="input-group-btn">
                      {{ Form::button('<span class="fa fa-pencil" title='.trans('chemical.structure').' aria-hidden="true"></span>',
                      ['class' => 'btn btn-secondary', 'id' => 'chemical-search-sketcher-open', 'data-toggle' => 'modal',
                      'data-target' => '#chemical-search-sketcher-modal', 'placeholder' => trans('chemical.structure.inchikey')]) }}
                    </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>