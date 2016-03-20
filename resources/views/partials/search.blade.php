<div class="panel-heading regular">
  {{ Form::open(['url' => Request::path(), 'method' => 'get', 'class' => 'form-horizontal']) }}
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <div class="input-group">
        {{ Form::label('search', trans('common.search'), ['class' => 'control-label input-group-addon']) }}
        {{ Form::input('text', 'search', Input::get('search'), ['class' => 'form-control', 'placeholder' => trans($module.'.search.ph')]) }}
        <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
      </div>
    </div>
    @if (isset($selectId))
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon"><span class="fa fa-{{ $module }}-{{ $selectId }} fa-fw"></span></div>
          {{ Form::label($selectId, null, ['class' => 'control-label sr-only']) }}
          {{ Form::select($selectId.'[]', $selectData, Input::get($selectId), ['class' => 'form-control selectpicker show-tick',
          'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10',
          'title' => trans($module.'.'.$selectId.'.all')]) }}
        </div>
      </div>
    @endif
  </div>
  {{ Form::close() }}

  {{--
  {{ Form::open(['url' => Request::path(), 'method' => 'get', 'class' => 'form-inline']) }}
   <div class="form-group">
    <div class="input-group">
      {{ Form::label('search', trans('common.search'), ['class' => 'control-label input-group-addon']) }}
      {{ Form::input('text', 'search', Input::get('search'), ['class' => 'form-control', 'placeholder' => trans($module.'.search.ph')]) }}
      <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
    </div>
    @if (isset($selectId))
      <div class="input-group">
        <div class="input-group-addon"><span class="fa fa-{{ $module }}-{{ $selectId }} fa-fw"></span></div>
        {{ Form::label($selectId, null, ['class' => 'control-label sr-only']) }}
        {{ Form::select($selectId.'[]', $selectData, Input::get($selectId), ['class' => 'form-control selectpicker show-tick width-full',
        'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10',
        'style' => 'width: 100%',
        'title' => trans($module.'.'.$selectId.'.all')]) }}
      </div>
    @endif
  </div>
  {{ Form::close() }}
  --}}
</div>