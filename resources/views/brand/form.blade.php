@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name or trans('brand.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($brand->id) ? ['module' => 'brand', 'action' => 'edit']
  : ['module' => 'brand', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($brand->id) ? $brand->name : trans('brand.new') }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('resource.header', ['module' => 'brand', 'item' => $brand, 'actions' => isset($brand->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $brand->name ? trans('common.info') : trans('brand.new') }}</a>
          </li>
        @endcomponent

        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <div class="card-body">
              @if (isset($brand->id))
                {{ Form::model($brand, ['method' => 'PATCH', 'route' => ['brand.update', $brand->id]]) }}
              @else
                {{ Form::model($brand, ['route' => ['brand.store']]) }}
              @endif
              <div class="form-group row">
                {{ Form::label('name', trans('brand.name'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10 col-lg-6">
                  {{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('brand.name')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('url_product', trans('brand.url.product'), ['class' => 'col-md-2 control-form-label']) }}
                <div class="col-md-10 col-lg-6">
                  {{ Form::input('text', 'url_product', null, ['class' => 'form-control', 'placeholder' => trans('brand.url.product')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('url_sds', trans('brand.url.sds'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10 col-lg-6">
                  {{ Form::input('text', 'url_sds', null, ['class' => 'form-control', 'placeholder' => trans('brand.url.sds')]) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('parse_callback', trans('brand.parse-callback'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10 col-lg-6">
                  {{ Form::select('parse_callback', $callbacks, null, ['class' => 'form-control selectpicker show-tick']) }}
                </div>
              </div>
              <div class="form-group row">
                {{ Form::label('description', trans('brand.description'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10 col-lg-6">
                  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('brand.description')]) }}
                </div>
              </div>
              <div class="form-group row">
                <div class="col-auto mx-auto">{{ HtmlEx::icon('common.save') }}</div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
