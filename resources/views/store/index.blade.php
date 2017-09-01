@extends('app')

@section('title-content')
  {{ trans('store.index') }}
@endsection

@section('content')
  @component('resource.nav', ['module' => 'store', 'action' => 'index'])
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <h5 class="card-header">{{ trans('store.index') }}</h5>
        <div id="store-list"></div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
    $('#store-list').treeview({
        data: <?php echo json_encode($stores); ?>,
        enableLinks: true,
        baseUrl: '/store/',
        showIcon: true,
        showEdit: <?php echo auth()->user()->can('store-edit') ? 'true' : 'false'; ?>,
        showDelete: <?php echo auth()->user()->can('store-delete') ? 'true' : 'false'; ?>
    });
</script>
@endpush
