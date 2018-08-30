<div class="row mt-4">
  <div class="col-sm-12">
    <div class="collapse" id="search-advanced">
      <div class="form-group form-row justify-content-end">
        <div class="col-md-8 col-lg-10">
          <div class="custom-control custom-checkbox mb-2">
            {{ Form::checkbox('group', 'group', true, ['class' => 'custom-control-input', 'id' => 'attr_group']) }}
            {{ Form::label('attr_group', trans('chemical.search.group'), ['class' => 'custom-control-label']) }}
          </div>
          <div class="custom-control custom-checkbox mb-2">
            {{ Form::checkbox('recent', 'recent', false, ['class' => 'custom-control-input', 'id' => 'attr_recent']) }}
            {{ Form::label('attr_recent', trans('chemical.search.recent'), ['class' => 'custom-control-label']) }}
          </div>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-md-4 col-lg-2 col-form-label">{{ trans('chemical.chemspider') }}</label>
        <div class="col-md-8 col-lg-4">
          {{ Form::input('text', 'chemspider', request()->get('chemspider'), ['class' => 'form-control', 'placeholder' => trans('chemical.chemspider')]) }}
        </div>
        <label class="col-md-4 col-lg-2 col-form-label">{{ trans('chemical.pubchem') }}</label>
        <div class="col-md-8 col-lg-4">
          {{ Form::input('text', 'pubchem', request()->get('pubchem'), ['class' => 'form-control', 'placeholder' => trans('chemical.pubchem')]) }}
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-md-4 col-lg-2 col-form-label">{{ trans('chemical.formula') }}</label>
        <div class="col-md-8 col-lg-4">
          {{ Form::input('text', 'formula', request()->get('formula'), ['class' => 'form-control', 'placeholder' => trans('chemical.formula')]) }}
        </div>
        <label class="col-md-4 col-lg-2 col-form-label">{{ trans('chemical.structure.inchikey') }}</label>
        <div class="col-md-8 col-lg-4">
          <div class="input-group">
            {{ Form::input('text', 'inchikey', request()->get('inchikey'), ['class' => 'form-control']) }}
            <div class="input-group-append">
              {{ Form::button('<span class="fas fa-fw fa-draw-polygon" title='.trans('chemical.structure').' aria-hidden="true"></span>',
                ['class' => 'btn btn-secondary', 'id' => 'chemical-search-sketcher-open', 'data-toggle' => 'modal',
                'data-target' => '#chemical-search-sketcher-modal', 'placeholder' => trans('chemical.structure.inchikey')]) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>