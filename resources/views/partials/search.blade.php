<div id="panel-heading-search" class="panel-heading regular">
  <div class="row">
    <div class="col-sm-11 col-md-10">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'class' => 'form-horizontal', 'id' => 'form-search']) }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="col-sm-2">
              @if($module == 'chemical')
                <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
                  <span class="fa fa-chevron-down" aria-hidden="true"></span>
                  Advanced {{-- trans('chemicals.search.advanced') --}}
                </a>
              @endif
            </div>
            <div class="col-sm-10 col-md-5">
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="search-clear" class="btn btn-default"><span class="fa fa-rotate-right"
                                                                     title="{{ trans('common.search.clear') }}"
                                                                     aria-hidden="true"></span></a>
                </span>
                {{ Form::label('s', trans('common.search'), ['class' => 'control-label sr-only']) }}
                {{ Form::input('text', 's', Input::get('s'), ['class' => 'form-control', 'placeholder' => trans('common.search')]) }}
                <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
              </div>
            </div>
            <div class="col-sm-10 col-md-5">
              @if (isset($selectId))
                <div class="input-group">
                  <div class="input-group-addon"><span class="fa fa-{{ $module }}-{{ $selectId }}"></span></div>
                  {{ Form::label($selectId, null, ['class' => 'control-label sr-only']) }}
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
              <div class="form-group form-group-sm">
                <label for="group" class="col-sm-4 col-md-2 control-label">
                  {{ trans('chemical.search.group') }}
                </label>
                <div class="checkbox col-sm-8 col-md-4">
                  {{ Form::checkbox('group', 'group', true) }}
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-sm-4 col-md-2 control-label">{{ trans('chemical.chemspider') }}</label>
                <div class="col-sm-8 col-md-4">
                  {{ Form::input('text', 'chemspider', Input::get('chemspider'), ['class' => 'form-control', 'placeholder' => trans('chemical.chemspider')]) }}
                </div>
                <label class="col-sm-4 col-md-2 control-label">{{ trans('chemical.pubchem') }}</label>
                <div class="col-sm-8 col-md-4">
                  {{ Form::input('text', 'pubchem', Input::get('pubchem'), ['class' => 'form-control', 'placeholder' => trans('chemical.pubchem')]) }}
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-sm-4 col-md-2 control-label">{{ trans('chemical.formula') }}</label>
                <div class="col-sm-8 col-md-4">
                  {{ Form::input('text', 'formula', Input::get('formula'), ['class' => 'form-control', 'placeholder' => trans('chemical.formula')]) }}
                </div>
                <label class="col-sm-4 col-md-2 control-label">{{ trans('chemical.structure.inchikey') }}</label>
                <div class="col-sm-8 col-md-4">
                  <div class="input-group input-group-sm">
                    {{ Form::input('text', 'inchikey', Input::get('inchikey'), ['class' => 'form-control']) }}
                    <span class="input-group-btn inp">
                  {{ Form::button('<span class="fa fa-pencil" title='.trans('chemical.structure').' aria-hidden="true"></span>', ['class' => 'btn btn-default', 'id' => 'chemical-search-sketcher-open', 'data-toggle' => 'modal', 'data-target' => '#chemical-search-sketcher-modal', 'placeholder' => trans('chemical.structure.inchikey')]) }}
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
    <div class="col-sm-1 col-md-2">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

