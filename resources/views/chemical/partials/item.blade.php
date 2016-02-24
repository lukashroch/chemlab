<tr class="{{ $item->id }}">
  {{ Form::model($item, ['class' => 'form-inline']) }}
  <td class="form-inline">
    {{ HtmlEx::icon('chemical.item') }}
    {{ Form::input('text', 'amount', null, ['id' => 'amount-'.$item->id, 'class' => 'form-control']) }}
    {{ Form::select('unit', ['0' => 'G', '1' => 'mL'], null, ['id' => 'unit-'.$item->id, 'class' => 'form-control']) }}
    <div class="input-group">
      <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
      {{ Form::select('store_id', $stores, null, ['id' => 'store-'.$item->id, 'class' => 'form-control']) }}
    </div>
    <p class="form-control-static"><span class="fa fa-chemical-item-date"
                                         aria-hidden="true"></span> {{ $item->added() }}</p>
  </td>
  <td>
    <div class="pull-right">{{ HtmlEx::icon('chemical.item.save', $item->id) }}{{ HtmlEx::icon('chemical.item.delete', $item->id) }}</div>
  </td>
  {{ Form::close() }}
</tr>