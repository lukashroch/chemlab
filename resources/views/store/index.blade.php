@extends('app')

@section('title')
  {{ trans('store.index') }}
@endsection

@section('content')
  @include('partials.actionbar', ['resource' => 'store'])

  <div class="card">
    <h5 class="card-header">{{ trans('store.index') }}</h5>
    <div id="store-list"></div>
  </div>
@endsection

@push('scripts')
  <script>
      $('#store-list').treeview({
          data: <?php echo json_encode($stores); ?>,
          enableLinks: true,
          baseUrl: '/store/',
          showIcon: true,
          showActions: true
      });
  </script>
@endpush
