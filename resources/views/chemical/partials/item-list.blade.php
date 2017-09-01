<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        @if (isset($chemical->id))
          {{ HtmlEx::icon('chemical-item.create', ['id' => 'chemical-item-create', 'class' => 'btn btn-primary btn-sm pull-right', 'data-toggle' => 'modal',
            'data-target' => '#chemical-item-modal', 'data-chemical_id' => $chemical->id]) }}
        @endif
        <h6 class="card-title">{{ HtmlEx::icon('chemical-item.index') }}</h6>
      </div>
      @if (isset($chemical->id))
        <table class="table table-sm table-hover table-list" id="chemical-items">
          <thead>
          <tr>
            <th>{{ trans('chemical.amount') }}</th>
            <th>{{ trans('store.title') }}</th>
            <th>{{ trans('chemical.date') }}</th>
            <th>{{ trans('chemical-item.owner') }}</th>
            @permission(['chemical-edit', 'chemical-delete'])
            <th class="text-center">{{ trans('common.action') }}</th>
            @endpermission
          </tr>
          </thead>
          <tbody>
          @forelse($chemical->items->sortBy('store.tree_name') as $item)
            @include('chemical.partials.item', ['item' => $item,
              'edit' => auth()->user()->can('chemical-edit'), 'delete' => auth()->user()->can('chemical-delete'), 'canManage' => auth()->user()->canManageStore($item->store_id)])
          @empty
            <tr class="warning">
              @if(auth()->user()->can(['chemical-edit', 'chemical-delete']))
                <th colspan="5">{{ trans('chemical-item.none') }}</th>
              @else
                <th colspan="4">{{ trans('chemical-item.none') }}</th>
              @endif
            </tr>
          @endforelse
          </tbody>
        </table>
      @else
        <div class="card-body">{{ trans('chemical.header.save') }}</div>
      @endif
    </div>
  </div>
</div>
@if (isset($chemical->id))
  <div class="modal fade" id="chemical-item-modal" aria-labelledby="chemical-item-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ trans('chemical-item.title') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          {{ Form::open(['role' => 'form', 'id' => 'chemical-item-form']) }}
          {{ Form::hidden('id', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          {{ Form::hidden('chemical_id', $chemical->id, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          <div class="form-group row">
            {{ Form::label('amount', trans('chemical.amount'), ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
              <div class="form-row">
                <div class="col-4">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="fa fa-chemical-item-amount fa-fw"></span></div>
                    {{ Form::input('text', 'amount', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                <div class="col-auto">
                  {{ Form::label('unit', null, ['class' => 'col-form-label sr-only']) }}
                  {{ Form::select('unit', ['1' => 'G', '2' => 'mL', '3' => 'unit', '0' => 'none'], null, ['class' => 'form-control selectpicker show-tick']) }}
                </div>
                <div class="col-auto">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="fa fa-chemical-item-count fa-fw"></span></div>
                    {{ Form::label('count', null, ['class' => 'col-form-label sr-only']) }}
                    {{ Form::selectRange('count', 1, 5, null, ['class' => 'form-control selectpicker show-tick']) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            {{ Form::label('store_id', trans('store.title'), ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                {{ Form::select('store_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
          <div class="form-group row">
            {{ Form::label('owner_id', trans('chemical-item.owner'), ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-index fa-fw"></span></div>
                {{ Form::select('owner_id', $users, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group">
            <div class="col-2">{{ HtmlEx::icon('common.save') }}</div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endif