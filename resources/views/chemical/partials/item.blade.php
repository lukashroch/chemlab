<tr class="{{ $item->id }}">
  <td>{{ HtmlEx::icon('chemical.item') }} {{ HtmlEx::unit($item->unit, $item->amount) }}</td>
  <td>{{ $item->store->tree_name }}</td>
  <td>{{ $item->added() }}</td>
  <td>{{ $item->owner->name or trans('common.not.specified') }}</td>
  @if ($action)
    <td class="text-center">
      @permission('chemical-edit')
      {{ HtmlEx::icon('chemical.item.edit', [
        'class' => 'btn btn-default', 'id' => 'chemical-item-edit', 'data-toggle' => 'modal',
        'data-target' => '#chemical-item-modal', 'data-id' => $item->id, 'data-chemical_id' => $item->chemical_id,
        'data-store_id' => $item->store_id, 'data-amount' => $item->amount, 'data-unit' => $item->unit,
        'data-owner_id' => $item->owner_id]) }}
      @endpermission
      @permission('chemical-delete')
      {{ HtmlEx::icon('chemical.item.delete', ['class' => 'btn btn-danger delete',
        'data-url' => route('chemical-item.delete', ['item' => $item->id]),
        'data-confirm' => trans('chemical.item.delete.confirm')]) }}
      @endpermission
    </td>
  @endif
</tr>