@extends('app')

@section('title-content')
  {{ trans('chemical.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'chemical', 'action' => 'index'])
@endsection

@section('content')
  @parent
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>

  @include('chemical.partials.move')
  @include('partials.structure-sketcher', ['id' => 'chemical-search-sketcher'])

  <div id="store-tree-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="store-tree-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{ trans('chemical.store.all') }}</h4>
        </div>
        <div class="modal-body">
          <div id="tree-modal"></div>
        </div>
        <div class="modal-footer">
          {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-default']) }}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
<script>
    <?php echo 'var stores = ' . json_encode($storeTree) . ';'; ?>

    $('#tree-modal').treeview({
        data: stores,
        enableLinks: true,
        baseUrl: '/chemical/stores/',
        showIcon: true
    });
</script>
@endpush
