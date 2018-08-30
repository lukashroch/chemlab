<tr class="{{ $item->id }}">
  <td>
    <span class="fas fa-fw fa-chemical-item-title ml-2" title="{{ trans('chemical-item.title') }}"></span>
    {{ Helper::unit($item->unit, $item->amount) }}</td>
  <td>{{ $item->store->tree_name }}</td>
  <td>{{ $item->added() }}</td>
  <td>{{ $item->owner->name ?? trans('common.not.specified') }}</td>
  <td class="text-center">
    @if (auth()->user()->can('chemical-edit', $item->store->team_id))
      <button class="btn btn-sm btn-secondary" id="chemical-item-edit" data-toggle="modal"
              data-target="#chemical-item-modal" data-id="{{ $item->id }}" data-chemical_id="{{ $item->chemical_id}}"
              data-store_id="{{ $item->store_id }}" data-amount="{{ $item->amount }}" data-unit="{{ $item->unit }}"
              data-owner_id="{{ $item->owner_id }}">
        <span class="fas fa-fw fa-chemical-item-edit" title="{{ trans('chemical-item.edit') }}"></span>
      </button>
    @endif
    @if (auth()->user()->can('chemical-delete', $item->store->team_id))
      <button class="btn btn-danger btn-sm delete"
              data-url="{{ route('chemical-item.delete', ['id' => $item->id]) }}"
              data-confirm="{{ trans('common.action.delete.confirm', ['name' => Helper::unit($item->unit, $item->amount)]) }}"
              data-response="chemical-item" title="{{ trans('chemical-item.delete') }}">
        <span class="fas fa-fw fa-chemical-item-delete" title="{{ trans('chemical-item.delete') }}"></span>
      </button>
    @endif
  </td>
</tr>
