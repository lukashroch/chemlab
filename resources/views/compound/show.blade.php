@extends('app')

@section('title-content')
  {{ trans('compound.title') }} | {{ $compound->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'compound', 'action' => 'show', 'data' => ['id' => $compound->id, 'name' => 'K'.$compound->id]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $compound->name }}</div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('compound.id') }}</th>
            <td colspan="3">
              {{ $compound->id }}
              {{ Form::hidden('id', $compound->id, ['id' => 'id']) }}
            </td>
          </tr>
          <tr>
            <th>{{ trans('compound.internal_id') }}</th>
            <td>{{ $compound->internal_id }}</td>
            <th>{{ trans('compound.owner') }}</th>
            <td>{{ $compound->owner->name or trans('compound.owner.unknown') }}</td>
          </tr>
          <tr>
            <th>{{ trans('compound.name') }}</th>
            <td colspan="3">{{ $compound->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('compound.mw') }}</th>
            <td>{{ $compound->mw }}</td>
            <th>{{ trans('compound.amount') }}</th>
            <td>{{ $compound->amount }}</td>
          </tr>
          <tr>
            <th>{{ trans('chemical.description') }}</th>
            <td colspan="3">
              {{ $compound->description }}
              {{ Form::hidden('smiles', $compound->smiles, ['id' => 'smiles', 'class' => 'form-control', 'readonly' => 'readonly']) }}
              {{ Form::hidden('sdf', $compound->sdf, ['id' => 'sdf', 'class' => 'form-control', 'readonly' => 'readonly']) }}
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('partials.structure-render', ['module' => 'compound', 'action' => 'show'])
@endsection
