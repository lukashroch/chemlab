<div class="panel-heading clearfix">
  {{ $item->name or trans($module.'.new') }}
  <div class="pull-right">
    @if($module == 'chemical' && isset($data) && $data == true)
      @include('chemical.partials.data')
    @endif
    <div class="btn-group btn-group-sm">
      @foreach ($actions as $action)
        {{ HtmlEx::icon($module.'.'.$action, ['id' => $item->id, 'name' => ($action == 'delete') ? $item->name : null]) }}
      @endforeach
    </div>
  </div>
</div>