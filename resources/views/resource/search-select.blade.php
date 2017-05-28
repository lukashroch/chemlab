<div class="input-group">
  <div class="input-group-addon"><span class="fa fa-{{ $selectName }}-index"></span></div>
  {{ Form::label($selectName, null, ['class' => 'sr-only']) }}
  {{ Form::select($selectName.'[]', $selectData, Input::get($selectName), ['class' => 'form-control selectpicker show-tick',
    'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10',
    'title' => trans($selectName.'.all')]) }}
  <span class="input-group-btn">{{ HtmlEx::icon('common.search') }}</span>
</div>