@extends('app')

@section('title-content')
  {{ trans('chemical.search') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'search'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading regular" id="chemical-search">
          {!! Form::open(['url' => 'chemical/search', 'method' => 'get', 'class' => 'form-horizontal']) !!}
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('chemical.name') }}</label>
            <div class="col-sm-10">
              {{ Form::input('text', 'name', Session::get('search.name'), ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => trans('chemical.name')]) }}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('chemical.brand.id') }}</label>
            <div class="col-sm-4">
              {{ Form::input('text', 'brand_no', Session::get('search.brand_no'), ['class' => 'form-control', 'placeholder' => trans('chemical.brand.id')]) }}
            </div>
            <label class="col-sm-2 control-label">{{ trans('chemical.cas') }}</label>
            <div class="col-sm-4">
              {{ Form::input('text', 'cas', Session::get('search.cas'), ['class' => 'form-control', 'placeholder' => trans('chemical.cas')]) }}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('chemical.chemspider') }}</label>
            <div class="col-sm-4">
              {{ Form::input('text', 'chemspider', Session::get('search.chemspider'), ['class' => 'form-control', 'placeholder' => trans('chemical.chemspider')]) }}
            </div>
            <label class="col-sm-2 control-label">{{ trans('chemical.pubchem') }}</label>
            <div class="col-sm-4">
              {{ Form::input('text', 'pubchem', Session::get('search.pubchem'), ['class' => 'form-control', 'placeholder' => trans('chemical.pubchem')]) }}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('chemical.formula') }}</label>
            <div class="col-sm-4">
              {{ Form::input('text', 'formula', Session::get('search.formula'), ['class' => 'form-control', 'placeholder' => trans('chemical.formula')]) }}
            </div>
            <label class="col-sm-2 control-label">{{ trans('chemical.structure') }}</label>
            <div class="col-sm-4">
              {{ Form::input('hidden', 'inchikey', Session::get('search.inchikey'), ['readonly' => 'readonly', 'class' => 'form-control']) }}
              {{ Form::button(trans(Session::get('search.sdf') ? 'chemical.structure.edit' : 'chemical.structure.draw'), ['class' => 'btn btn-primary', 'id' => 'chemical-search-sketcher-open', 'data-toggle' => 'modal', 'data-target' => '#chemical-search-sketcher-modal']) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('store_id', trans('store.title'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                {{ Form::select('store_id[]', $stores, Session::get('search.store_id'), ['id' => 'store_id', 'class' => 'form-control selectpicker show-tick',
                'multiple' => 'multiple', 'data-selected-text-format' => 'count', 'data-actions-box' => 'true', 'data-size' => '10', 'title' => trans('chemical.store.all')]) }}
              </div>
            </div>
            {{ Form::label('date_operant', trans('chemical.date'), ['class' => 'control-label sr-only']) }}
            {{ Form::label('date', trans('chemical.date'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-4 form-inline">
              {{ Form::select('date_operant', ['' => trans('chemical.date.anytime'), '%3D' => trans('chemical.date.day'), '%3C' => trans('chemical.date.before'), '%3E' => trans('chemical.date.after')] , Session::get('search.date_operant'), ['class' => 'form-control', 'id' => 'date_operant']) }}
              <div class="input-group pull-right">
                <div class="input-group-addon"><span class="fa fa-common-date fa-fw"></span></div>
                {{ Form::date('date', empty(Session::get('search.date')) ? '' : Session::get('search.date'), ['class' => 'form-control', 'id' => 'date']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">{{ Form::reset(trans('chemical.search.reset'), ['type' => 'reset', 'class' => 'btn btn-danger pull-right']) }}</div>
            <div class="col-sm-6">{{ Form::button('<span class="fa fa-chemical-search" aria-hidden="true"></span> '.trans('chemical.search.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('chemical.search.result') }}</label>
            <div class="col-sm-6"><p
                      class="form-control-static">{{ $chemicals->count() }} {{ trans('chemical.search.result.no')}}</p>
            </div>
          </div>
          {{ Form::close() }}
          @include('partials.structure-sketcher', ['id' => 'chemical-search-sketcher'])
        </div>
        @include('chemical.partials.list')
      </div>
    </div>
  </div>
@endsection
