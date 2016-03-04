<table class="table table-striped table-hover">
  <thead>
  <tr>
    <th>{{ trans('store.name') }}</th>
    <th>{{ trans('store.temp') }}</th>
    @if ($action)
      <th class="text-center">{{ trans('common.action') }}</th>
    @endif
  </tr>
  </thead>
  <tbody>
  @forelse($stores as $store)
    <tr class="clickable" data-href="{{ route('store.show', ['id' => $store->id]) }}">
      <td>{{ HtmlEx::icon('store.show', $store->id, ['name' => $store->prefix.' - '.$store->name]) }}</td>
      <td>{{ trans('store.temp.int', ['min' => $store->temp_min, 'max' => $store->temp_max]) }}</td>
      @if ($action)
        <td class="text-center">
          {{ HtmlEx::icon('store.edit', $store->id) }}
          {{ HtmlEx::icon('store.delete', $store->id, ['name' => $store->prefix.' - '.$store->name]) }}
        </td>
      @endif
    </tr>
  @empty
    <tr class="warning">
      <th colspan="{{ $action ? '3' : '2'}}">{{ trans('common.query.empty') }}</th>
    </tr>
  @endforelse
  </tbody>
  <tfoot>
  <tr>
    <th class="text-center" colspan="{{ $action ? '3' : '2'}}">{{ $stores->render() }}</th>
  </tr>
  </tfoot>
</table>