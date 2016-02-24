@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name or trans('brand.new') }}
@endsection

@section('head-content')
  @if (isset($brand->id))
    {{ HtmlEx::menu('brand', 'edit', ['id' => $brand->id, 'name' => $brand->name]) }}
  @else
    {{ HtmlEx::menu('brand', 'create', ['name' => trans('brand.new')]) }}
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $brand->name or trans('brand.new') }}</div>
        <div class="panel-body">
          @if (isset($brand->id))
            {{ Form::model($brand, ['method' => 'PATCH', 'action' => ['BrandController@update', $brand->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($brand, ['action' => ['BrandController@store'], 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('brand.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'name', null, ['class' => 'form-control due', 'placeholder' => trans('brand.name')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('pattern', trans('brand.pattern'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::input('text', 'pattern', null, ['class' => 'form-control', 'placeholder' => trans('brand.pattern')]) }}</div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('brand.description'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 col-md-6">{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'placeholder' => trans('brand.description')]) }}</div>
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
