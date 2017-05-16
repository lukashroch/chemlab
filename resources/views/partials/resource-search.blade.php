<div id="panel-heading-search" class="card-header">
  <div class="row">
    <div class="col-sm-10">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group row">
            <div class="col-sm-1 col-lg-2">
              @if($module == 'chemical')
                <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
                  <span class="fa fa-chevron-down" aria-hidden="true"></span>
                  <span class="hidden-md-down">{{ trans('chemical.search.advanced') }}</span>
                </a>
              @endif
            </div>
            <div class="col-sm-11 col-lg-5">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-secondary" id="search-clear">
                    <span class="fa fa-rotate-right" title="{{ trans('common.search.clear') }}" aria-hidden="true"></span>
                  </button>
                </span>
                {{ Form::label('s', trans('common.search'), ['class' => 'sr-only']) }}
                {{ Form::input('text', 's', Input::get('s'), ['class' => 'form-control typeahea', 'placeholder' => trans('common.search')]) }}
                <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
              </div>
            </div>
            <div class="col-sm-11 push-sm-1 push-lg-0 col-lg-5">
              @if (isset($selectId))
                <div class="input-group">
                  <div class="input-group-addon"><span class="fa fa-{{ $module }}-{{ $selectId }}"></span></div>
                  {{ Form::label($selectId, null, ['class' => 'sr-only']) }}
                  {{ Form::select($selectId.'[]', $selectData, Input::get($selectId), ['class' => 'form-control selectpicker show-tick',
                    'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10',
                    'title' => trans($module.'.'.$selectId.'.all')]) }}
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      @if($module == 'chemical')
        <div class="row">
          <div class="col-sm-12">
            <div class="collapse" id="search-advanced">
              <div class="form-group form-group-sm row">
                <div class="checkbox col-sm-8 push-sm-4 col-md-5 push-md-1 col-lg-4 push-lg-2">
                  <label for="group">
                    {{ Form::checkbox('group', 'group', true) }}
                    {{ trans('chemical.search.group') }}
                  </label>
                </div>
                <div class="checkbox col-sm-8 push-sm-4 col-md-5 push-md-1 col-lg-4 push-lg-2">
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
      @endif
    </div>
    {{ Form::close() }}
    <div class="col-sm-2">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

