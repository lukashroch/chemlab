<div>
  {!! HtmlEx::icon($module . '.show', ['id' => $item->id]) . " "
  . HtmlEx::icon($module . '.edit', ['id' => $item->id]) . " "
  . HtmlEx::icon($module . '.delete', ['id' => $item->id, 'name' => $item->name, 'response' => 'dt']) !!}
</div>
