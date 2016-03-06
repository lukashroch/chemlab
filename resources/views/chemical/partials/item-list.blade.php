<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-12">
            {{ HtmlEx::icon('chemical.items') }}
            @if (isset($chemical->id))
              <div class="pull-right">
                {{ HtmlEx::icon('chemical.item.create', null, ['id' => 'chemical-item-create', 'class' => 'btn btn-primary btn-sm', 'data-toggle' => 'modal',
                  'data-target' => '#chemical-item-modal', 'data-chemical_id' => $chemical->id]) }}
              </div>
            @endif
          </div>
        </div>
      </div>
      @if (isset($chemical->id))
        <table class="table table-hover" id="chemical-items">
          <thead>
          <tr>
            <th>{{ trans('chemical.amount') }}</th>
            <th>{{ trans('store.title') }}</th>
            <th>{{ trans('chemical.date') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($chemical->itemList() as $item)
            @include('chemical.partials.item', ['item' => $item])
          @empty
            <tr class="warning">
              <th colspan="{{ $action == 'edit' ? '4' : '3'}}">{{ trans('chemical.stock.none') }}</th>
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
          <h4 class="modal-title">{{ trans('chemical.structure') }}</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['role' => 'form', 'id' => 'chemical-item-form', 'class' => 'form-horizontal']) }}
          {{ Form::hidden('id', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          {{ Form::hidden('chemical_id', $chemical->id, ['class' => 'form-control', 'readonly' => 'readonly']) }}
          <div class="form-group">
            {{ Form::label('amount', trans('chemical.amount'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9 form-inline">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-chemical-item-amount fa-fw"></span></div>
                {{ Form::input('text', 'amount', null, ['class' => 'form-control']) }}
              </div>
              {{ Form::label('unit', null, ['class' => 'control-label sr-only']) }}
              {{ Form::select('unit', ['0' => 'G', '1' => 'mL'], null, ['class' => 'form-control selectpicker show-tick', 'data-width' => 'fit']) }}
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-chemical-item-count fa-fw"></span></div>
                {{ Form::label('count', null, ['class' => 'control-label sr-only']) }}
                {{ Form::selectRange('count', 1, 5, null, ['class' => 'form-control, selectpicker show-tick', 'data-width' => 'fit']) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('store_id', trans('store.title'), ['class' => 'col-sm-3 control-label']) }}
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-store-index fa-fw"></span></div>
                {{ Form::select('store_id', $stores, null, ['class' => 'form-control selectpicker show-tick']) }}
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          {{ HtmlEx::icon('chemical.item.save', null, ['id' => 'chemical-item-save', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endif