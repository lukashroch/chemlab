<div id="actionToolbar" class="card mb-5">
  <div class="card-body">
    <div class="row">
      @permission($resource.'-create')
      <div class="col-auto">
        @include('partials.actions.create', ['resource' => $resource])
      </div>
      @endpermission
      @if($resource != 'store')
        <div class="col-auto">
          <button class="btn btn-primary action" title="{{ trans('common.action.detail') }}" data-action="show">
            <span class="fas fa-fw fa-file" title="{{ trans('common.action.detail') }}"></span>
            {{ trans('common.action.detail') }}
          </button>
          @permission($resource.'-edit')
          <button class="btn btn-primary action" title="{{ trans('common.action.edit') }}" data-action="edit">
            <span class="fas fa-fw fa-pencil-alt" title="{{ trans('common.action.edit') }}"></span>
            {{ trans('common.action.edit') }}
          </button>
          @endpermission
        </div>
        <div class="col-auto">
          <button class="btn btn-primary" title="{{ trans('common.export') }}" data-toggle="modal"
                  data-target="#export-modal">
            <span class="fas fa-fw fa-share" title="{{ trans('common.export') }}"></span>
            {{ trans('common.export') }}
          </button>
          @if($resource == 'chemical' && auth()->user()->can($resource.'-edit'))
            <button class="btn btn-primary move" title="{{ trans('chemical-item.move') }}" data-toggle="modal"
                    data-target="#chemical-item-move-modal" data-action="move">
              <span class="fas fa-fw fa-exchange-alt" title="{{ trans('chemical-item.move') }}"></span>
              {{ trans('chemical-item.move') }}
            </button>
          @endif
        </div>
        <div class="col-auto ml-auto">
          @permission($resource.'-delete')
          <button class="btn btn-danger delete" title="{{ trans('common.action.delete') }}"
                  data-url="{{ route($resource == 'chemical' ? 'chemical-item.delete' : $resource.'.delete') }}"
                  data-action="multi-delete"
                  data-confirm="{{ trans('common.action.multi.delete.confirm') }}" data-response="dt">
            <span class="fas fa-fw fa-trash" title="{{ trans('common.action.multi.delete') }}"></span>
            {{ trans('common.action.multi.delete') }}
          </button>
          @endpermission
        </div>
      @endif
    </div>
  </div>
</div>

@includeWhen($resource != 'store', 'partials.export-modal')
