<div class="row">
  <div class="col-sm-12">
    <ul class="nav nav-pills nav-justified">
      <li class="nav-item">
        <a class="nav-link{{ request()->segment(2) == 'overview' ? ' active' : '' }}"
           href="{{ route('admin.overview') }}">
          <span class="fa fa-admin-overview" aria-hidden="true" title="{{ trans('admin.overview') }}"></span>
          {{ trans('admin.overview') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link{{ request()->segment(2) == 'dbbackup' ? ' active' : '' }}"
           href="{{ route('admin.dbbackup') }}">
          <span class="fa fa-admin-dbbackup" aria-hidden="true" title="{{ trans('admin.dbbackup') }}"></span>
          {{ trans('admin.dbbackup') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link{{ request()->segment(2) == 'cache' ? ' active' : '' }}" href="{{ route('admin.cache') }}">
          <span class="fa fa-admin-cache" aria-hidden="true" title="{{ trans('admin.cache') }}"></span>
          {{ trans('admin.cache') }}
        </a>
      </li>
    </ul>
  </div>
</div>
<br/>

