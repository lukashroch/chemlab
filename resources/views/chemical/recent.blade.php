@extends('app')

@section('title-content')
  {{ trans('chemical.recent') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('chemical', 'recent', ['name' => Input::get('store') ? $stores[Input::get('store')] : null]) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical', 'select' => $stores])
        <table class="table table-striped table-hover" id="chemical-recent">
          <thead>
          <tr>
            <th>{{ trans('chemical.title') }}</th>
            <th>{{ trans('store.title') }}</th>
            <th>{{ trans('chemical.amount') }}</th>
            <th>{{ trans('chemical.date') }}</th>
          </tr>
          </thead>
          <tbody>
          @unless ($chemicals->isEmpty())
            @foreach($chemicals as $chemical)
              <tr>
                <td>{{ HtmlEx::icon('chemical.show', $chemical->chemical_id, $chemical->description ? $chemical->name.' ('.$chemical->description.')' : $chemical->name) }}</td>
                <td title="{{ $chemical->stores }}">{{ str_limit($chemical->stores, 25) }}</td>
                <td>{{ HtmlEx::unit($chemical->unit, $chemical->amount) }}</td>
                <td>{{ $chemical->created_at->formatLocalized('%d %B %Y (%H:%M)') }}</td>
              </tr>
            @endforeach
            <tr>
              <th class="text-center" colspan="5">{{ $chemicals->render() }}</th>
            </tr>
            @else
              <tr class="warning">
                <th colspan="5">{{ trans('common.query.empty') }}</th>
              </tr>
              @endunless
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
