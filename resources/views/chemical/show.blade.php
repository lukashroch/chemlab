@extends('app')

@section('title-content')
  {{ trans('chemical.title') }} | {{ $chemical->name }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'chemical', 'action' => 'show'])
    <li class="breadcrumb-item">{{ $chemical->name }}</li>
  @endcomponent

  <div class="row mb-3">
    <div class="col-sm-12">
      <div class="card" id="chemical">
        @component('resource.header', ['module' => 'chemical', 'item' => $chemical, 'actions' => ['edit', 'delete']])
          <li class="nav-item">
            <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
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
        <div class="tab-content">
          <div class="tab-pane active" id="info" role="tabpanel">
            <table class="table table-hover">
              <tbody>
              <tr>
                <th>{{ trans('chemical.name') }}</th>
                <td colspan="3">
                  {{ $chemical->name }}
                  {{ Form::hidden('id', $chemical->id, ['id' => 'id']) }}
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.name.iupac') }}</th>
                <td colspan="3">{{ $chemical->iupac_name }}</td>
              </tr>
              <tr>
                <th>{{ trans('chemical.synonym') }}</th>
                <td colspan="3">{{ $chemical->synonym }}</td>
              </tr>
              <tr>
                <th>{{ trans('chemical.brand.id') }}</th>
                <td>{{ $chemical->formatBrandLink() }}</td>
                <th>{{ trans('chemical.brand.name') }}</th>
                <td>{{ $chemical->brand->name or trans('common.not.specified') }}</td>
              </tr>
              <tr>
                <th>{{ trans('chemical.cas') }}</th>
                <td>{{ $chemical->cas }}</td>
                <th>{{ trans('chemical.pubchem') }}</th>
                <td>
                  @if(!empty($chemical->pubchem))
                    @foreach(explode(';', $chemical->pubchem) as $id)
                      {{ HtmlEx::icon('chemical.pubchem.link', ['id' => $id]) }}
                    @endforeach
                  @endif
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.mw') }}</th>
                <td>{{ $chemical->mw }}</td>
                <th>{{ trans('chemical.formula') }}</th>
                <td>{!! preg_replace("/(\d+)/", "<sub>$1</sub>", $chemical->formula) !!}
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.chemspider') }}</th>
                <td colspan="3">
                  @if(!empty($chemical->chemspider))
                    @foreach(explode(';', $chemical->chemspider) as $id)
                      {{ HtmlEx::icon('chemical.chemspider.link', ['id' => $id]) }}
                    @endforeach
                  @endif
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.description') }}</th>
                <td colspan="3">{{ $chemical->description }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="msds" role="tabpanel">
            @include('chemical.partials.msds')
            @include('chemical.partials.msds-modal')
          </div>
          <div class="tab-pane" id="structure" role="tabpanel">
            <table class="table table-hover">
              <tbody>
              <tr>
                <th>{{ trans('chemical.structure.inchikey') }}</th>
                <td>
                  {{ $chemical->structure->inchikey }}
                  {{ Form::hidden('inchikey', $chemical->structure->inchikey, ['id' => 'inchikey', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.structure.inchi') }}</th>
                <td>
                  {{ $chemical->structure->inchi }}
                  {{ Form::hidden('inchi', $chemical->structure->inchi, ['id' => 'inchi', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </td>
              </tr>
              <tr>
                <th>{{ trans('chemical.structure.smiles') }}</th>
                <td>
                  {{ $chemical->structure->smiles }}
                  {{ Form::hidden('smiles', $chemical->structure->smiles, ['id' => 'smiles', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                  {{ Form::hidden('sdf', $chemical->structure->sdf, ['id' => 'sdf', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                </td>
              </tr>
              </tbody>
            </table>
            @include('chemical.partials.sdf', ['module' => 'chemical', 'action' => 'show'])
            <div class="structure-render" id="molecule"></div>
            <iframe class="hidden-sm-up" id="ketcher" src="{{ url('vendor/ketcher-v2/render.html') }}"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('chemical.partials.item-list')
@endsection
