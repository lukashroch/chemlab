<div class="panel-heading regular">
  {{ Form::open(array('url' => Request::path(), 'method' => 'get', 'class' => 'form-horizontal')) }}
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <div class="input-group">
        {{ Form::label('search', trans('common.search'), ['class' => 'control-label input-group-addon']) }}
        {{ Form::input('text', 'search', Input::get('search'), ['class' => 'form-control', 'placeholder' => trans($module.'.search.ph')]) }}
      </div>
    </div>
    @if ($module == 'chemical' || $module == 'store')
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon"><span class="fa fa-department-index fa-fw"></span></div>
          @if ($module == 'chemical')
            {{ Form::label('store', null, ['class' => 'control-label sr-only']) }}
            {{ Form::select('store', [ null => trans('store.all')] + $select, Input::get('store'), ['class' => 'form-control']) }}
          @else
            {{ Form::label('department', null, ['class' => 'control-label sr-only']) }}
            {{ Form::select('department', [ null => trans('department.all')] + $select, Input::get('department'), ['class' => 'form-control']) }}
          @endif
        </div>
      </div>
    @elseif($module == 'compound')
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon"><span class="fa fa-compound-owner fa-fw"></span></div>
            {{ Form::label('owner', null, ['class' => 'control-label sr-only']) }}
            {{ Form::select('owner', $select, Input::get('owner'), ['class' => 'form-control']) }}
        </div>
      </div>
    @endif
    <div class="col-sm-2">{{ HtmlEx::icon('common.search') }}</div>
  </div>
  {{ Form::close() }}
</div>