@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name or trans('brand.new') }}
@endsection

@section('head-content')
  @if (isset($brand->id))
    @include('partials.header', ['module' => 'brand', 'action' => 'edit', 'data' => ['name' => $brand->name]])
  @else
    @include('partials.header', ['module' => 'brand', 'action' => 'create', 'data' => ['name' => trans('brand.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'brand', 'item' => $brand, 'actions' => isset($brand->id) ? ['show', 'delete'] : []])
        <div class="panel-body">
          @if (isset($brand->id))
            {{ Form::model($brand, ['method' => 'PATCH', 'route' => ['brand.update', $brand->id], 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($brand, ['route' => ['brand.store'], 'class' => 'form-horizontal']) }}
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
