@extends('app')

@section('title-content')
  {{ trans('store.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('store', 'index') }}
@endsection

@section('scripts')
  <script>
    <?php echo 'var stores = ' . json_encode($stores) . ';'; ?>

    $('#tree').treeview({
      data: stores,
      enableLinks: true,
      baseUrl: '/store/',
      showActions: true,
    });

    $('#main').on('click', '#test', function (event) {
      event.preventDefault();
      //var selected = $('#tree').treeview('getSelected');
      //alert(selected[0].text);
      console.log(stores);

    });
  </script>
@endsection

@section('content')
  {{ Form::button('test', ['id' => 'test']) }}
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'store'])
        <div class="list-group" id="tree"></div>
      </div>
    </div>
  </div>
@endsection
