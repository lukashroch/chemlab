@extends('app')

@section('title-content')
  {{ trans('store.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'store', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading regular">
          <h4 class="panel-title">{{ trans('store.index')  }}</h4>
        </div>
        <div class="list-group" id="store-list"></div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
    <?php echo 'var stores = ' . json_encode($stores) . ';'; ?>

    $('#store-list').treeview({
        data: stores,
        enableLinks: true,
        baseUrl: '/store/',
        showIcon: true,
        showEdit: <?php echo Entrust::can('store-edit') ? 'true' : 'false'; ?>,
        showDelete: <?php echo Entrust::can('store-delete') ? 'true' : 'false'; ?>
    });
</script>
@endpush
