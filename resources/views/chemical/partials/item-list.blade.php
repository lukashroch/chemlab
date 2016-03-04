<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-12">
            {{ trans('chemical.stock') }}
            @if ($action == 'edit')
              <div class="pull-right">
                {{ HtmlEx::icon('chemical.item.add', null, ['class' => 'btn btn-primary btn-sm', 'id' => 'chemical-item-add', 'data-toggle' => 'modal', 'data-target' => '#chemical-item-modal']) }}
              </div>
            @endif
          </div>
        </div>
      </div>
      <table class="table table-hover">
        <thead>
        <tr>
          <th>{{ trans('chemical.amount') }}</th>
          <th>{{ trans('store.title') }}</th>
          <th>{{ trans('chemical.date') }}</th>
          @if ($action == 'edit')
            <th class="text-center">{{ trans('common.action') }}</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
          @include('chemical.partials.item', ['item' => $item, 'action' => $action])
        @empty
          <tr class="warning">
            <th colspan="{{ $action == 'edit' ? '4' : '3'}}">{{ trans('chemical.stock.none') }}</th>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>