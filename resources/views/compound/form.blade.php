@extends('app')

@section('title-content')
  {{ trans('compound.title') }} | {{ $compound->name or trans('compound.new') }}
@endsection

@section('head-content')
  @if (isset($compound->id))
    @include('partials.header', ['module' => 'compound', 'action' => 'edit', 'data' => ['id' => $compound->id, 'name' => $compound->name]])
  @else
    @include('partials.header', ['module' => 'compound', 'action' => 'create', 'data' => ['name' => trans('compound.new')]])
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-sm-10">{{ $compound->name or trans('compound.new') }}</div>
          </div>
        </div>
        <div class="panel-body" id="chemical-edit">
          @if (isset($compound->id))
            {{ Form::model($compound, ['method' => 'PATCH', 'action' => ['CompoundController@update', $compound->id], 'id' => 'compound-form', 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($compound, ['action' => ['CompoundController@store'], 'id' => 'compound-form', 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('internal_id', trans('compound.internal_id'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'internal_id', null, ['id' => 'internal_id', 'class' => 'form-control', 'autofocus' => 'enabled']) }}
            </div>
            {{ Form::label('owner_id', trans('compound.owner'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-compound-owner fa-fw"></span></div>
                {{ Form::select('owner_id', [null => trans('compound.owner.unknown')] + $owners, null, ['id' => 'owner_id', 'class' => 'form-control selectpicker']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('name', trans('compound.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::input('text', 'name', null, ['id' => 'name', 'class' => 'form-control due']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('mw', trans('compound.mw'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'mw', null, ['id' => 'mw', 'class' => 'form-control']) }}
            </div>
            {{ Form::label('amount', trans('compound.amount'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'amount', null, ['id' => 'amount', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group hidden">
            {{ Form::label('structure-data', trans('compound.structure'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::label('inchikey', null, ['class' => 'control-label sr-only']) }}
              {{ Form::hidden('inchikey', null, ['id' => 'inchikey', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::label('inchi', null, ['class' => 'control-label sr-only']) }}
              {{ Form::hidden('inchi', null, ['id' => 'inchi', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::label('smiles', null, ['class' => 'control-label sr-only']) }}
              {{ Form::hidden('smiles', null, ['id' => 'smiles', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::label('sdf', null, ['class' => 'control-label sr-only']) }}
              {{ Form::hidden('sdf', null, ['id' => 'sdf', 'class' => 'form-control', 'readonly' => 'readonly']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('description', trans('compound.description'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">{{ Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control', 'rows' => '4']) }}</div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  @include('partials.structure-render', ['module' => 'compound', 'action' => 'edit'])
  @include('partials.structure-sketcher', ['id' => 'structure-sketcher'])
@endsection
