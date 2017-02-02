@extends('app')

@section('title-content')
  {{ trans('user.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'user', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'user'])
        {!! $dataTable->table() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
<script>

    $(document).ready( function() {

        $('#main').on('click', 'button.test', function (event) {
            event.preventDefault();

            var table = $("#dataTableBuilder").DataTable();
            console.log(table.rows({selected: true}).data().pluck('id'));
        });

        /*$('#user-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'roles', name: 'roles'}
            ],
            dom : '<"panel panel-default"<"panel-heading"<"row"<"col-sm-6"l><"col-sm-6"fB>>>' +
              '<"row"<"col-sm-12"tr>>' +
            '<"panel-footer"<"row"<"col-sm-12"p>>>>',
            buttons : ['csv', 'excel', 'pdf', 'print'],
            'pageLength' : '25',
        });*/
    });
</script>
@endpush
