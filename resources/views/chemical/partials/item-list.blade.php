<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        @if (isset($chemical->id))
          {{ HtmlEx::icon('chemical-item.create', ['id' => 'chemical-item-create', 'class' => 'btn btn-primary btn-sm pull-right', 'data-toggle' => 'modal',
            'data-target' => '#chemical-item-modal', 'data-chemical_id' => $chemical->id]) }}
        @endif
        <h4 class="panel-title">{{ HtmlEx::icon('chemical-item.index') }}</h4>
      </div>
      @if (isset($chemical->id))
        <table class="table table-hover table-list" id="chemical-items">
          <thead>
          <tr>
            <th>{{ trans('chemical.amount') }}</th>
            <th>{{ trans('store.title') }}</th>
            <th>{{ trans('chemical.date') }}</th>
            <th>{{ trans('chemical-item.owner') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($chemical->items->sortBy('store.tree_name') as $item)
            @include('chemical.partials.item', ['item' => $item])
          @empty
            <tr class="warning">
              <th colspan="{{ $action == 'edit' ? '5' : '4'}}">{{ trans('chemical-item.none') }}</th>
            </tr>
          @endforelse
          </tbody>
        </table>
      @else
        <div class="panel-body">{{ trans('chemical.header.save') }}</div>
      @endif
    </div>
  </div>
</div>
@if (isset($chemical->id))
  <div class="modal fade" id="chemical-item-modal" tabindex="-1" role="dialog" aria-labelledby="chemical-item-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{ trans('chemical-item.title') }}</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['role' => 'form', 'id' => 'chemical-item-form', 'class' => 'form-horizontal']) }}
          {{ Form::hidden('id', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          {{ Form::hidden('chemical_id', $chemical->id, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          <div class="form-group">
            {{ Form::label('amount', trans('chemical.amount'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10 form-inline">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-chemical-item-amount fa-fw"></span></div>
                {{ Form::input('text', 'amount', null, ['class' => 'form-control']) }}
              </div>
              {{ Form::label('unit', null, ['class' => 'control-label sr-only']) }}
              {{ Form::select('unit', ['1' => 'G', '2' => 'mL', '3' => 'unit', '0' => 'none'], null, ['class' => 'form-control selectpicker show-tick', 'data-width' => 'fit']) }}
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-chemical-item-count fa-fw"></span></div>
                {{ Form::label('count', null, ['class' => 'control-label sr-only']) }}
                {{ Form::selectRange('count', 1, 5, null, ['class' => 'form-control selectpicker show-tick', 'data-width' => 'fit']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('store_id', trans('store.title'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                {{ Form::select('store_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('owner_id', trans('chemical.owner'), ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-user-index fa-fw"></span></div>
                {{ Form::select('owner_id', $users, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          {{ HtmlEx::icon('common.save') }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endif