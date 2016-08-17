@extends('chemical.layout')

@section('title-content')
  {{ trans('chemical.title') }} | {{ $chemical->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'show', 'data' => ['id' => $chemical->id, 'name' => $chemical->name]])
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">{{ $chemical->name }}</h4>
        </div>
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
            <td>{{ $chemical->formatBrandLink() }}
            </td>
            <th>{{ trans('chemical.brand.name') }}</th>
            <td>{{ $chemical->brand->name or trans('common.not.specified') }}</td>
          </tr>
          <tr>
            <th>{{ trans('chemical.cas') }}</th>
            <td>{{ $chemical->cas }}</td>
            <th>{{ trans('chemical.pubchem') }}</th>
            <td>{{ HtmlEx::icon('chemical.pubchem.link', $chemical->pubchem, $chemical->pubchem) }}</td>
          </tr>
          <tr>
            <th>{{ trans('chemical.mw') }}</th>
            <td>{{ $chemical->mw }}</td>
            <th>{{ trans('chemical.formula') }}</th>
            <td>{{ $chemical->formatChemicalFormula()  }}</td>
          </tr>
          <tr>
            <th>{{ trans('chemical.chemspider') }}</th>
            <td colspan="3">{{ HtmlEx::icon('chemical.chemspider.link', $chemical->chemspider, $chemical->chemspider) }}</td>
          </tr>
          <tr>
            <th>{{ trans('chemical.description') }}</th>
            <td colspan="3">
              {{ $chemical->description }}
              {{ Form::hidden('inchikey', $chemical->structure->inchikey, ['id' => 'inchikey', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::hidden('inchi', $chemical->structure->inchi, ['id' => 'inchi', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::hidden('smiles', $chemical->structure->smiles, ['id' => 'smiles', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::hidden('sdf', $chemical->structure->sdf, ['id' => 'sdf', 'class' => 'form-control', 'readonly' => 'readonly']) }}
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('chemical.partials.item-list')
  @include('partials.structure-render', ['module' => 'chemical', 'action' => 'show'])

  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">{{ trans('chemical.msds.title') }}</h4>
        </div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('chemical.msds.h-pictogram') }}</th>
            <td>
              @foreach($chemical->getHPictogram() as $item)
                <b>{{ $item }}</b>
                {!! Html::image('images/ghs/'.$item.'.gif', $item, ['height' => '100', 'width' => '100']) !!}
              @endforeach
            </td>
          </tr>
          <tr>
            <th>{{ trans('chemical.msds.signal_word') }}</th>
            <td>
              {{ $chemical->signal_word }}
            </td>
          </tr>
          <tr>
            <th>{{ trans('chemical.msds.h-statement') }}</th>
            <td>
              @foreach($chemical->getHStatement() as $item)
                <b>{{ $item }}</b> - {{ trans('h-statement.'.$item) }} <br />
              @endforeach
            </td>
          </tr>
          <tr>
            <th>{{ trans('chemical.msds.p-statement') }}</th>
            <td>
              @foreach($chemical->getPStatement() as $item)
                <b>{{ $item }}</b> - {{ trans('p-statement.'.$item) }} <br />
              @endforeach
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
