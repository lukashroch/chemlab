@extends('app')

@section('title-content')
  {{ trans('chemical.index') }}
@endsection

@section('content')
  @component('partials.resource-nav', ['module' => 'chemical', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @include('partials.resource-search', ['module' => 'chemical', 'selectId' => 'store', 'selectData' => $stores])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>

  @include('chemical.partials.move')
  @include('chemical.partials.sketcher', ['id' => 'chemical-search-sketcher'])

  <div id="store-tree-modal" class="modal fade" aria-labelledby="store-tree-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ trans('chemical.store.all') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div id="tree-modal"></div>
        </div>
        <div class="modal-footer">
          {{ Form::button(trans('common.close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-secondary']) }}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
<script>
    $('#tree-modal').treeview({
        data: <?php echo json_encode($storeTree); ?>,
        enableLinks: true,
        baseUrl: '/chemical/stores/',
        showIcon: true
    });
</script>
@endpush
