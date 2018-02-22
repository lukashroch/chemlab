@extends('app')

@section('title-content')
  {{ trans('chemical.title') }} | {{ $chemical->name or trans('chemical.new') }}
@endsection

@section('content')
  @component('resource.nav', isset($chemical->id) ? ['module' => 'chemical', 'action' => 'edit']
  : ['module' => 'chemical', 'action' => 'create'])
    <li class="breadcrumb-item">{{ isset($chemical->id) ? $chemical->name : trans('chemical.new') }}</li>
  @endcomponent

  <div class="row mb-3">
    <div class="col-sm-12">
      <div class="card" id="chemical">
        @component('resource.header', ['module' => 'chemical', 'item' => $chemical, 'actions' => isset($chemical->id) ? ['show', 'delete'] : []])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab"
               role="tab">{{ $chemical->name ? trans('common.info') : trans('chemical.new') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#msds" data-toggle="tab" role="tab">{{ trans('msds.title') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="toggle-tab-structure" href="#structure" data-toggle="tab" role="tab">
              {{ trans('chemical.structure') }}
            </a>
          </li>
        @endcomponent
        <div class="card-body" id="chemical-edit">
          {{ Form::model($chemical, isset($chemical->id) ?
              ['method' => 'PATCH', 'route' => ['chemical.update', $chemical->id], 'id' => 'chemical-form', 'enctype' => 'multipart/form-data']
              : ['route' => ['chemical.store'], 'id' => 'chemical-form', 'enctype' => 'multipart/form-data']) }}
          <div class="tab-content">
            <div class="tab-pane active" id="info" role="tabpanel">
              <div class="form-group form-row">
                {{ Form::label('name', trans('chemical.name'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'name', null, ['id' => 'name', 'class' => 'form-control due', 'autofocus' => 'enabled']) }}
                  {{ Form::hidden('id', null, ['id' => 'id']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('iupac_name', trans('chemical.name.iupac'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'iupac_name', null, ['id' => 'iupac_name', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('synonym', trans('chemical.synonym'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'synonym', null, ['id' => 'synonym', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('catalog_id', trans('chemical.brand.id'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'catalog_id', null, ['id' => 'catalog_id', 'class' => 'form-control']) }}
                </div>
                {{ Form::label('brand_id', trans('chemical.brand.name'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="fa fa-brand-index fa-fw"></span></div>
                    {{ Form::select('brand_id', $brands, null, ['id' => 'brand_id', 'class' => 'form-control selectpicker show-tick']) }}
                  </div>
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('cas', trans('chemical.cas'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'cas', null, ['id' => 'cas', 'class' => 'form-control']) }}
                </div>
                {{ Form::label('pubchem', trans('chemical.pubchem'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'pubchem', null, ['id' => 'pubchem', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('mw', trans('chemical.mw'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'mw', null, ['id' => 'mw', 'class' => 'form-control']) }}
                </div>
                {{ Form::label('formula', trans('chemical.formula'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'formula', null, ['id' => 'formula', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('chemspider', trans('chemical.chemspider'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'chemspider', null, ['id' => 'chemspider', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('description', trans('chemical.description'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control', 'rows' => '4']) }}
                </div>
              </div>
            </div>

            <div class="tab-pane" id="msds" role="tabpanel">
              <div class="form-group form-row">
                {{ Form::label('sds', trans('msds.sds'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  <label class="custom-file">
                    <input type="file" name="sds" class="custom-file-input" accept="application/pdf">
                    <span class="custom-file-control"></span>
                  </label>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                  @if(Storage::disk('local')->exists("sds/{$chemical->id}.pdf"))
                    <p class="form-control-static">
                      <a href="{{ route('chemical.get-sds', ['chemical' => $chemical->id]) }}">
                        <span class="fa fa-file-pdf-o"></span> {{ trans('msds.sds.get') }}
                      </a>
                    </p>
                  @endif
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('symbol', trans('msds.symbol_title'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::select('symbol[]', trans('msds.symbol'), null, ['id' => 'symbol', 'class' => 'form-control selectpicker show-tick', 'multiple' => 'multiple',
                  'data-selected-text-format' => 'count', 'data-size' => '10']) }}
                </div>
                {{ Form::label('signal_word', trans('msds.signal_word'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::input('text', 'signal_word', null, ['id' => 'signal_word', 'class' => 'form-control']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('h', trans('msds.h_abbr'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::select('h[]', array_map(function ($data) { return str_limit($data, 35); }, trans('msds.h')), null,
                  ['id' => 'h', 'class' => 'form-control selectpicker show-tick', 'multiple' => 'multiple',
                  'data-selected-text-format' => 'count', 'data-size' => '10']) }}
                </div>
                {{ Form::label('p', trans('msds.p_abbr'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-4">
                  {{ Form::select('p[]', array_map(function ($data) { return str_limit($data, 35); }, trans('msds.p')), null,
                  ['id' => 'p', 'class' => 'form-control selectpicker show-tick', 'multiple' => 'multiple',
                  'data-selected-text-format' => 'count', 'data-size' => '10']) }}
                </div>
              </div>
            </div>

            <div class="tab-pane" id="structure" role="tabpanel">
              <div class="form-group form-row">
                {{ Form::label('inchikey', trans('chemical.structure.inchikey'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'inchikey', $chemical->structure ? $chemical->structure->inchikey : null, ['id' => 'inchikey', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('inchi', trans('chemical.structure.inchi'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'inchi', $chemical->structure ? $chemical->structure->inchi : null, ['id' => 'inchi', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </div>
              </div>
              <div class="form-group form-row">
                {{ Form::label('smiles', trans('chemical.structure.smiles'), ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                  {{ Form::input('text', 'smiles', $chemical->structure ? $chemical->structure->smiles : null, ['id' => 'smiles', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </div>
              </div>
              <div class="form-group form-row d-none">
                {{ Form::label('sdf', trans('chemical.structure.sdf'), ['class' => 'col-md-2 col-form-label sr-only']) }}
                <div class="col-md-10">
                  {{ Form::hidden('sdf', $chemical->structure ? $chemical->structure->sdf : null, ['id' => 'sdf', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </div>
              </div>
              @include('chemical.partials.sdf', ['module' => 'chemical', 'action' => 'edit'])
              <div class="structure-render" id="molecule"></div>
            </div>
          </div>
        </div>
        <div class="card-footer pb-0">
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  @include('chemical.partials.item-list')
  @include('chemical.partials.sketcher', ['id' => 'structure-sketcher'])
@endsection
