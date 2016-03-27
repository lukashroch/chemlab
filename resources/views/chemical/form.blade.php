@extends('chemical.layout')

@section('title-content')
  {{ trans('chemical.title') }} | {{ $chemical->name or trans('chemical.new') }}
@endsection

@section('head-content')
  @if (isset($chemical->id))
    @include('partials.header', ['module' => 'chemical', 'action' => 'edit', 'data' => ['id' => $chemical->id, 'name' => $chemical->name]])
  @else
    @include('partials.header', ['module' => 'chemical', 'action' => 'create', 'data' => ['name' => trans('chemical.new')]])
  @endif
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          @include('chemical.partials.data')
          <h4 class="panel-title">{{ $chemical->name or trans('chemical.new') }}</h4>
        </div>
        <div class="panel-body" id="chemical-edit">
          @if (isset($chemical->id))
            {{ Form::model($chemical, ['method' => 'PATCH', 'action' => ['ChemicalController@update', $chemical->id], 'id' => 'chemical-form', 'class' => 'form-horizontal']) }}
          @else
            {{ Form::model($chemical, ['action' => ['ChemicalController@store'], 'id' => 'chemical-form', 'class' => 'form-horizontal']) }}
          @endif
          <div class="form-group">
            {{ Form::label('name', trans('chemical.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::input('text', 'name', null, ['id' => 'name', 'class' => 'form-control due', 'autofocus' => 'enabled']) }}
              {{ Form::hidden('id', null, ['id' => 'id']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('iupac_name', trans('chemical.name.iupac'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::input('text', 'iupac_name', null, ['id' => 'iupac_name', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('synonym', trans('chemical.synonym'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::input('text', 'synonym', null, ['id' => 'synonym', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('brand_no', trans('chemical.brand.id'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'brand_no', null, ['id' => 'brand_no', 'class' => 'form-control']) }}
            </div>
            {{ Form::label('brand_id', trans('chemical.brand.name'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-brand-index fa-fw"></span></div>
                {{ Form::select('brand_id', $brands, null, ['id' => 'brand_id', 'class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('cas', trans('chemical.cas'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'cas', null, ['id' => 'cas', 'class' => 'form-control']) }}
            </div>
            {{ Form::label('pubchem', trans('chemical.pubchem'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'pubchem', null, ['id' => 'pubchem', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('mw', trans('chemical.mw'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'mw', null, ['id' => 'mw', 'class' => 'form-control']) }}
            </div>
            {{ Form::label('formula', trans('chemical.formula'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              {{ Form::input('text', 'formula', null, ['id' => 'formula', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('chemspider', trans('chemical.chemspider'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              {{ Form::input('text', 'chemspider', null, ['id' => 'chemspider', 'class' => 'form-control']) }}
            </div>
          </div>
          <div class="form-group hidden">
            {{ Form::label('structure-data', trans('chemical.structure'), ['class' => 'col-sm-2 control-label']) }}
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
            {{ Form::label('description', trans('chemical.description'), ['class' => 'col-sm-2 control-label']) }}
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
  @include('chemical.partials.item-list')
  @include('partials.structure-render', ['module' => 'chemical', 'action' => 'edit'])
  @include('partials.structure-sketcher', ['id' => 'structure-sketcher'])
@endsection
