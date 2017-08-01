<tr class="{{ $item->id }}">
  <td>{{ HtmlEx::icon('chemical-item.title') }} {{ HtmlEx::unit($item->unit, $item->amount) }}</td>
  <td>{{ $item->store->tree_name }}</td>
  <td>{{ $item->added() }}</td>
  <td>{{ $item->owner->name or trans('common.not.specified') }}</td>
  <td class="text-center">
    @if($edit == true)
      {{ HtmlEx::icon('chemical-item.edit', [
        'class' => 'btn btn-sm btn-secondary', 'id' => 'chemical-item-edit', 'data-toggle' => 'modal',
        'data-target' => '#chemical-item-modal', 'data-id' => $item->id, 'data-chemical_id' => $item->chemical_id,
        'data-store_id' => $item->store_id, 'data-amount' => $item->amount, 'data-unit' => $item->unit,
        'data-owner_id' => $item->owner_id, 'disable' => !$canManage]) }}
    @endif
    @if($delete == true)
      {{ HtmlEx::icon('chemical-item.delete', ['id' => $item->id, 'name' => 'selected item', 'response' => 'chemical-item', 'disable' => !$canManage]) }}
    @endif
  </td>
</tr>
