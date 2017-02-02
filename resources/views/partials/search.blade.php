<div class="panel-heading regular">
  <div class="row">
    <div class="col-sm-10">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'class' => 'form-horizontal', 'id' => 'form-search']) }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="col-sm-2">
              <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
                <span class="fa fa-chevron-down" aria-hidden="true"></span>
                Advanced {{-- trans('chemicals.search.advanced') --}}
              </a>
            </div>
            <div class="col-sm-5">
              <div class="input-group">
                {{ Form::label('s', trans('common.search'), ['class' => 'control-label input-group-addon']) }}
                {{ Form::input('text', 's', Input::get('s'), ['class' => 'form-control', 'placeholder' => trans($module.'.search.ph')]) }}
                <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
              </div>
            </div>
            <div class="col-sm-5">
              @if (isset($selectId))
                <div class="input-group">
                  <div class="input-group-addon"><span class="fa fa-fw fa-{{ $module }}-{{ $selectId }}"></span></div>
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
      <div class="row">
        <div class="col-sm-12">
          <div class="collapse" id="search-advanced">
            <div class="checkbox">
              <label for="group">
                {{ Form::checkbox('group', 'group', true) }}{{ trans('chemical.search.group') }}
              </label>
            </div>
          </div>
        </div>
      </div>
      {{ Form::close() }}
    </div>
    <div class="col-sm-2">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

