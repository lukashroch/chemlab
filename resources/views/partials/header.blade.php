@if ($module == 'chemical')
  {{ Form::button('<span class="fa fa-store-index"></span>', ['class' => 'btn btn-sm btn-primary btn-store-view', 'data-toggle' => 'modal', 'data-target' => '#store-tree-modal']) }}
@endif

<li>{{ HtmlEx::icon($module . ".index") }}</li>

@if (isset($data['name']))
  <li>{{ $data['name'] }}</li>
@endif

{{ HtmlEx::icon($module.'.create', ['titleToText' => true]) }}
