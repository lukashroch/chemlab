@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name or trans('store.new') }}
@endsection

@section('head-content')
  @if (isset($store->id))
    @include('partials.header', ['module' => 'store', 'action' => 'edit', 'data' => ['name' => $store->name]])
  @else
    @include('partials.header', ['module' => 'store', 'action' => 'create', 'data' => ['name' => trans('store.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'store', 'item' => $store, 'actions' => isset($store->id) ? ['show', 'delete'] : []])
        <div class="panel-body">
          @if (isset($store->id))
            {{ Form::model($store, ['method' => 'PATCH', 'route' => ['store.update', $store->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($store, ['route' => ['store.store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('store.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('store.name')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('abbr_name', trans('store.abbr_name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              {{ Form::input('text', 'abbr_name', null, ['class' => 'form-control', 'placeholder' => trans('store.abbr_name')]) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('parent_id', trans('store.parent'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                {{ Form::select('parent_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label(null, trans('store.temp'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6 form-inline">
              <div class="input-group">
                {{ Form::label('store.temp.min', trans('store.temp.min'), ['class' => 'control-label sr-only']) }}
                <span class="input-group-addon">{{ trans('store.temp.min') }}</span>
                {{ Form::input('number', 'temp_min', null, ['id' => 'temp_min', 'class' => 'form-control', 'placeholder' => trans('store.temp.min')]) }}
                <span class="input-group-addon">°C</span>
                {{ Form::label('store.temp.max', trans('store.temp.max'), ['class' => 'control-label sr-only']) }}
                <span class="input-group-addon">{{ trans('store.temp.max') }}</span>
                {{ Form::input('number', 'temp_max', null, ['id' => 'temp_max', 'class' => 'form-control', 'placeholder' => trans('store.temp.max')]) }}
                <span class="input-group-addon">°C</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('store.description'), ['class' => 'col-sm-2 control-label']) }}
            <div
                class="col-sm-10 col-md-6 ">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('store.description')]) }}</div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-6">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
