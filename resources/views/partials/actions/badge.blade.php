<button class="btn btn-sm float-right {{ $action == 'attach' ? 'btn-success' : 'btn-danger' }}"
        title="{{ trans('common.badge.'.$action) }}">
  <span class="fa fa-common-badge-{{ $action }}"></span>
</button>