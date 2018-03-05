<tr class="{{ $item->id }}">
  <td>
    <span class="fa fa-fw fa-chemical-item-title ml-2" title="{{ trans('chemical-item.title') }}"></span>
    {{ HtmlEx::unit($item->unit, $item->amount) }}</td>
  <td>{{ $item->store->tree_name }}</td>
  <td>{{ $item->added() }}</td>
  <td>{{ $item->owner->name or trans('common.not.specified') }}</td>
  <td class="text-center">
    @if (auth()->user()->hasPermission('chemical-edit', $item->store->team_id))
      <button class="btn btn-sm btn-secondary" id="chemical-item-edit" data-toggle="modal"
              data-target="#chemical-item-modal" data-id="{{ $item->id }}" data-chemical_id="{{ $item->chemical_id}}"
              data-store_id="{{ $item->store_id }}" data-amount="{{ $item->amount }}" data-unit="{{ $item->unit }}"
              data-owner_id="{{ $item->owner_id }}">
        <span class="fa fa-fw fa-chemical-item-edit" title="{{ trans('chemical-item.edit') }}"></span>
      </button>
    @endif
    @include('partials.actions.delete', ['resource' => 'chemical-item', 'entry' => $item, 'response' => 'dt'])
  </td>
</tr>
