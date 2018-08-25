@extends('app')

@section('title')
  {{ $brand->name ?? trans('brand.new') }}
@endsection

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'brand', 'item' => $brand, 'actions' => isset($brand->id) ? ['show', 'delete'] : []])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab"
           role="tab">{{ $brand->name ? trans('common.info') : trans('brand.new') }}</a>
      </li>
    @endcomponent

    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
        <div class="card-body">
          {{ Form::model($brand, isset($brand->id) ? ['method' => 'PATCH', 'route' => ['brand.update', $brand->id]] : ['route' => ['brand.store']]) }}
          <div class="form-group form-row">
            {{ Form::label('name', trans('brand.name'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::input('text', 'name', null, ['class' => 'form-control', 'placeholder' => trans('brand.name')]) }}
              @includeWhen($errors->has('name'), 'partials.error', ['entry' => 'name'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('url_product', trans('brand.url.product'), ['class' => 'col-md-3 control-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::input('text', 'url_product', null, ['class' => 'form-control', 'placeholder' => trans('brand.url.product')]) }}
              @includeWhen($errors->has('url_product'), 'partials.error', ['entry' => 'url_product'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('url_sds', trans('brand.url.sds'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::input('text', 'url_sds', null, ['class' => 'form-control', 'placeholder' => trans('brand.url.sds')]) }}
              @includeWhen($errors->has('url_sds'), 'partials.error', ['entry' => 'url_sds'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('parse_callback', trans('brand.parse-callback'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::select('parse_callback', $callbacks, null, ['class' => 'form-control selectpicker show-tick']) }}
              @includeWhen($errors->has('parse_callback'), 'partials.error', ['entry' => 'parse_callback'])
            </div>
          </div>
          <div class="form-group form-row">
            {{ Form::label('description', trans('brand.description'), ['class' => 'col-md-3 col-form-label']) }}
            <div class="col-md-9 col-lg-6">
              {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('brand.description')]) }}
              @includeWhen($errors->has('description'), 'partials.error', ['entry' => 'description'])
            </div>
          </div>
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">
              @include('partials.actions.save')
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
