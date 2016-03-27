<div class="btn-group btn-group-sm pull-right">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
          aria-expanded="false">
    <span class="fa fa-nav-options" aria-hidden="true"></span>
    {{ trans('common.options') }}
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" role="menu">

    @if (Entrust::can($module . '-edit'))
      <li><a href="{{ route($module . '.create') }}"><span class="fa fa-fw fa-{{ $module }}-create"
                                                           aria-hidden="true"></span> {{ trans($module . '.create') }}
        </a></li>
      <li role="presentation" class="divider"></li>
    @endif

    @if ($module == "chemical" && ($action != 'show' && $action != 'edit'))
      <li>
        <a href="{{ route($module . '.export', ['type' => $action, 'store' => Route::current()->getParameter('store', null)]) }}?{{ $_SERVER['QUERY_STRING'] }}"
           target="_blank">
          <span class="fa fa-fw fa-{{$module}}-export" aria-hidden="true"></span>{{ trans($module . '.export') }}
        </a>
      </li>
      <li role="presentation" class="divider"></li>
    @endif
    @if ($action == 'edit')
      @if (Entrust::can($module . '-show'))
        <li>
          <a href="{{ route($module . '.show', [$module => $data['id']]) }}">
                  <span class="fa fa-fw fa-{{ $module }}-show"
                        aria-hidden="true"></span>{{ trans($module . '.show') }}
          </a>
        </li>
      @endif
      @if (Entrust::can($module . '-delete'))
        <li><a class="delete" data-action="{{ route($module . '.delete', ['delete' => $data['id']]) }}"
               data-confirm="{{ trans('common.action.delete.confirm', ['name' => $data['name']]) }}">
                  <span class="fa fa-fw fa-{{ $module }}-delete"
                        aria-hidden="true"></span>{{ trans($module . '.delete')}}</a>
        </li>
      @endif
      <li role="presentation" class="divider"></li>
    @elseif ($action == 'show')
      @if (Entrust::can($module . '-edit'))
        <li>
          <a href="{{ route($module . '.edit', [$module => $data['id']]) }}">
                  <span class="fa fa-fw fa-{{ $module }}-edit"
                        aria-hidden="true"></span>{{ trans($module . '.edit') }}
          </a>
        </li>
      @endif
      @if (Entrust::can($module . '-delete'))
        <li><a class="delete" data-action="{{ route($module . '.delete', ['delete' => $data['id']]) }}"
               data-confirm="{{ trans('common.action.delete.confirm', ['name' => $data['name']]) }}">
                  <span class="fa fa-fw fa-{{ $module }}-delete"
                        aria-hidden="true"></span>{{ trans($module . '.delete')}}</a>
        </li>
      @endif
      <li role="presentation" class="divider"></li>
    @endif

    <li><a href="{{ Session::get('_previous') ? url(Session::get('_previous')['url']) : "#" }}"><span
                class="fa fa-fw fa-common-back" aria-hidden="true"></span>{{ trans('common.back') }}</a></li>
  </ul>
</div>

@if ($module == 'chemical')
  {{ Form::button('<span class="fa fa-store-index"></span>', ['class' => 'btn btn-sm btn-primary btn-store-view', 'data-toggle' => 'modal', 'data-target' => '#store-tree-modal']) }}
@endif

@if ($action == 'recent' || $action == 'search')
  <li>{{ HtmlEx::icon($module . "." . $action) }}</li>
@else
  <li>{{ HtmlEx::icon($module . ".index") }}</li>
@endif

@if (isset($data['name']))
  <li>{{ $data['name'] }}</li>
@endif
@if (Input::get('search') != null)
  <li>{{Input::get('search') }}</li>
@endif


