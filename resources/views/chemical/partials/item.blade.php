<tr class="{{ $item->id }}">
  <td>{{ HtmlEx::icon('chemical.item') }} {{ HtmlEx::unit($item->unit, $item->amount) }}</td>
  <td>{{ $item->store->tree_name }}</td>
  <td>{{ $item->added() }}</td>
  <td>{{ $item->owner ? $item->owner->name : 'none' }}</td>
  @if ($action)
    <td class="text-center">
      @permission('chemical-edit')
      {{ HtmlEx::icon('chemical.item.edit', null, [
        'class' => 'btn btn-default', 'id' => 'chemical-item-edit', 'data-toggle' => 'modal',
        'data-target' => '#chemical-item-modal', 'data-id' => $item->id, 'data-chemical_id' => $item->chemical_id,
        'data-store_id' => $item->store_id, 'data-amount' => $item->amount, 'data-unit' => $item->unit,
        'data-owner_id' => $item->owner_id]) }}
      @endpermission
      @permission('chemical-delete')
      {{ HtmlEx::icon('chemical.item.delete', null, ['class' => 'btn btn-danger', 'id' => 'chemical-item-delete',
        'data-id' => $item->id, 'data-confirm' => trans('chemical.item.delete.confirm')]) }}
      @endpermission
    </td>
  @endif
</tr>