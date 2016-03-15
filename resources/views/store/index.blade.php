@extends('app')

@section('title-content')
  {{ trans('store.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('store', 'index', ['name' => Input::get('department') && !is_array(Input::get('department')) ? $departments[Input::get('department')] : null]) }}
@endsection

@section('scripts')
  <script>
    <?php echo 'var stores = ' . json_encode($storeTree) . ';'; ?>

    $(document).ready(function () {
      $('#tree').treeview({
        data: stores,
        enableLinks: true,
        baseUrl: 'store/'
      });


      $('#main').on('click', '#test', function (event) {
        event.preventDefault();
        var selected = $('#tree').treeview('getSelected', 2);
        //alert(selected[0].text);
        console.log(selected[0].name);

      });
    });

  </script>
@endsection

@section('content')
  {{ Form::button('test', ['id' => 'test']) }}
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'store', 'selectId' => 'department', 'selectData' => $departments])
        <div class="list-group" id="tree"></div>
      </div>
    </div>
  </div>
@endsection
