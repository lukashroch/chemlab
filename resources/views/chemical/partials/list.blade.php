<table class="table table-striped table-hover table-list" id="chemical-list">
  <thead>
  <tr>
    <th>{{ trans('chemical.title') }}</th>
    <th>{{ trans('chemical.brand.id') }}</th>
    <th>{{ trans('store.title') }}</th>
    <th>{{ trans('chemical.amount') }}</th>
    @if ($action)
      <th class="text-center">{{ trans('common.action') }}</th>
    @endif
  </tr>
  </thead>
  <tbody>
  @forelse($chemicals->items() as $chemical)
    <tr class="clickable{{ $chemical->stores ? '' : ' warning' }}"
        data-href="{{ route('chemical.show', ['id' => $chemical->id]) }}">
      <td>{{ HtmlEx::icon('chemical.show', ['id' => $chemical->id, 'name' => $chemical->getDisplayNameWithDesc()]) }}</td>
      <td>{{ $chemical->formatBrandLink() }}</td>
      @if ($chemical->stores)
        <td title="{{ $chemical->stores }}">{{ str_limit($chemical->stores, 25) }}</td>
        <td>{{ HtmlEx::unit($chemical->unit, $chemical->amount) }}</td>
      @else
        <td colspan="2">{{ trans('chemical.items.none')}}</td>
      @endif
      @if ($action)
        <td class="text-center">
          {{ HtmlEx::icon('chemical.edit', [$chemical->id]) }}
          {{ HtmlEx::icon('chemical.delete', ['id' => $chemical->id, 'name' => $chemical->name]) }}
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
    <th class="text-center" colspan="{{ $action ? '5' : '4'}}">{{ $chemicals->render() }}</th>
  </tr>
  </tfoot>
</table>