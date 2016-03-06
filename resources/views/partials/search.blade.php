<div class="panel-heading regular">
  {{ Form::open(['url' => Request::path(), 'method' => 'get', 'class' => 'form-horizontal']) }}
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <div class="input-group">
        {{ Form::label('search', trans('common.search'), ['class' => 'control-label input-group-addon']) }}
        {{ Form::input('text', 'search', Input::get('search'), ['class' => 'form-control', 'placeholder' => trans($module.'.search.ph')]) }}
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
    <div class="col-sm-2">{{ HtmlEx::icon('common.search') }}</div>
  </div>
  {{ Form::close() }}
</div>