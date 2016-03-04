@extends('app')

@section('title-content')
  {{ trans('compound.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('compound', 'index', ['name' => Input::get('owner') && !is_array(Input::get('owner')) ? $owners[Input::get('owner')] : null]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'compound', 'selectId' => 'owner', 'selectData' => $owners])
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>{{ trans('compound.id') }}</th>
            <th>{{ trans('compound.internal_id') }}</th>
            <th>{{ trans('compound.name') }}</th>
            <th>{{ trans('compound.owner') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($compounds as $compound)
            <tr class="clickable" data-href="{{ route('compound.show', ['id' => $compound->id]) }}">
              <td>{{ HtmlEx::icon('compound.show', $compound->id, ['name' => 'K'.$compound->id]) }}</td>
              <td>{{ $compound->internal_id }}</td>
              <td>{{ $compound->name }}</td>
              <td>{{ $compound->owner_name or trans('compound.owner.unknown') }}</td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('compound.edit', $compound->id) }}
                  {{ HtmlEx::icon('compound.delete', $compound->id, ['name' => $compound->name]) }}
                </td>
              @endif
            </tr>
          @empty
            <tr class="warning">
              <th colspan="{{ $action ? '5' : '4'}}">{{ trans('common.query.empty') }}</th>
            </tr>
          @endforelse
          </tbody>
          <tfoot>
          <tr>
            <th class="text-center" colspan="{{ $action ? '5' : '4'}}">{{ $compounds->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
