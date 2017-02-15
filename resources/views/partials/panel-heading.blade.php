<div class="panel-heading clearfix">
  {{ $item->name or trans($module.'.new') }}
  <div class="pull-right">
    @if($module == 'chemical' && isset($data) && $data == true)
      @include('chemical.partials.data')
    @endif
    <div class="btn-group btn-group-sm">
      @foreach ($actions as $action)
        {{ HtmlEx::icon($module.'.'.$action, $action == 'delete' ?
        ['id' => $item->id, 'name' => $item->name, 'response' => 'redirect'] : ['id' => $item->id]) }}
      @endforeach
    </div>
  </div>
</div>