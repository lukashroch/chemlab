@extends('app')

@section('title-content')
  {{ trans('chemical.title') }} | {{ $chemical->name }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('chemical', 'show', ['id' => $chemical->id, 'name' => $chemical->name]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $chemical->name }}</div>
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
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('chemical.stock') }}</div>
        <table class="table table-hover">
          <thead>
          <tr>
            <th>{{ trans('store.title') }}</th>
            <th>{{ trans('chemical.date') }}</th>
            <th>{{ trans('chemical.amount') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse($chemical->itemList() as $item)
            <tr>
              <td>{{ HtmlEx::icon('chemical.item', null, $item->prefix.' - '.$item->name) }}</td>
              <td>{{ $item->added() }}</td>
              <td>{{ HtmlEx::unit($item->unit, $item->amount) }}</td>
            </tr>
          @empty
            <tr class="warning">
              <th colspan="3">{{ trans('chemical.stock.none') }}</th>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('partials.structure-render', ['module' => 'chemical', 'action' => 'show'])
@endsection
