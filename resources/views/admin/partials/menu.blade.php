<div class="row">
  <div class="col-sm-12">
    <ul class="nav nav-pills nav-justified">
      <li class="{{ Request::segment(2) == 'overview' ? 'active' : '' }}">{{ HtmlEx::icon('admin.overview') }}</li>
      <li class="{{ Request::segment(2) == 'dbbackup' ? 'active' : '' }}">{{ HtmlEx::icon('admin.dbbackup') }}</li>
      <li class="{{ Request::segment(2) == 'cache' ? 'active' : '' }}">{{ HtmlEx::icon('admin.cache') }}</li>
    </ul>
  </div>
</div>
<br/>