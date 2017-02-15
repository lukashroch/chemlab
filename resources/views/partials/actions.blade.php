<div class="hidden-xs hidden-sm">
  {!! HtmlEx::icon($module . '.show', ['id' => $item->id]) . " "
  . HtmlEx::icon($module . '.edit', ['id' => $item->id]) . " "
  . HtmlEx::icon($module . '.delete', ['id' => $item->id, 'name' => $item->name, 'response' => 'dt']) !!}
</div>
<div class="hidden-md hidden-lg">
  <div class="btn-group btn-group-sm pull-right dropdown">
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" aria-haspopup="true"
            aria-expanded="false"
            data-toggle="modal" data-target="#actions-modal">
      <span class="fa fa-nav-options" aria-hidden="true"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-left" role="menu" id="" style="position: relative">
      <li><a>sss</a></li>
      <li><a>sss</a></li>
    </ul>
  </div>

  <div class="modal fade" id="actions-modal" tabindex="-1" role="dialog"
       aria-labelledby="actions-modal">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body">
          {!! HtmlEx::icon($module . '.show', ['id' => $item->id]) . " "
          . HtmlEx::icon($module . '.edit', ['id' => $item->id]) . " "
          . HtmlEx::icon($module . '.delete', ['id' => $item->id, 'name' => $item->name, 'response' => 'dt']) !!}
        </div>
      </div>
    </div>
  </div>

</div>
