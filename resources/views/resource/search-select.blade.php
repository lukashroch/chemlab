<div class="col-sm-12 col-lg-6">
    {{ Form::label($selectName, null, ['class' => 'sr-only']) }}
    {{ Form::select($selectName.'[]', $selectData, request()->get($selectName), ['class' => 'form-control selectpicker show-tick',
      'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10',
      'title' => trans($selectName.'.all')]) }}
  {{ HtmlEx::icon('common.search') }}
</div>