@extends('app')

@section('title-content')
  {{ trans('chemical.recent') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'recent',
    'data' => ['name' => Input::get('store') && !is_array(Input::get('store')) ? $stores[Input::get('store')] : null]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
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
          @forelse($chemicals as $chemical)
            <tr class="clickable" data-href="{{ route('chemical.show', ['id' => $chemical->chemical_id]) }}">
              <td>{{ HtmlEx::icon('chemical.show', $chemical->chemical_id, ['name' => $chemical->getDisplayNameWithDesc()]) }}</td>
              <td>{{ str_limit($chemical->stores, 25) }}</td>
              <td>{{ HtmlEx::unit($chemical->unit, $chemical->amount) }}</td>
              <td>{{ $chemical->created_at->formatLocalized('%d %b %Y (%H:%M)') }}</td>
            </tr>
          @empty
            <tr class="warning">
              <th colspan="5">{{ trans('common.query.empty') }}</th>
            </tr>
          @endforelse
          </tbody>
          <tfoot>
          <tr>
            <th class="text-center" colspan="4">{{ $chemicals->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
