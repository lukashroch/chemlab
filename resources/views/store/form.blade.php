@extends('app')

@section('title-content')
  {{ trans('store.title') }} | {{ $store->name or trans('store.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($store->id) ? ['module' => 'store', 'action' => 'edit']
  : ['module' => 'store', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($store->id) ? $store->name : trans('store.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'store', 'item' => $store, 'actions' => isset($store->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $store->name ? trans('common.info') : trans('store.new') }}</a>
          </li>
        @endcomponent
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <div class="card-block">
              {{ Form::model($store, isset($store->id) ? ['method' => 'PATCH', 'route' => ['store.update', $store->id]]
              : ['route' => ['store.store']]) }}
              <div class="form-group row">
                {{ Form::label('name', trans('store.name'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-8 col-lg-6">
                  {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('store.name')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('abbr_name', trans('store.abbr_name'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-8 col-lg-6">
                  {{ Form::input('text', 'abbr_name', null, ['class' => 'form-control', 'placeholder' => trans('store.abbr_name')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('parent_id', trans('store.parent'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-8 col-lg-6">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                    {{ Form::select('parent_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
                  </div>
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label(null, trans('store.temp'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-8 col-lg-6 form-inline">
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
              <div class="form-group row">
                {{ Form::label('description', trans('store.description'), ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10 col-md-8 col-lg-6">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('store.description')]) }}
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-auto mx-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
