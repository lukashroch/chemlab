@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('head-content')
  {{ trans('admin.title')}}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-default pull-right" href="{{ route('admin.dbbackup.create') }}"><span
                        class="fa fa-dbbackup-create" aria-hidden="true"></span> {{ trans('admin.dbbackup.create') }}
              </a>
            </div>
          </div>
        </div>
        <div class="panel-body">
          @if ($files)
            <table class="table table-hover">
              <thead>
              <tr>
                <th>{{ trans('common.name') }}</th>
                <th>{{ trans('common.date') }}</th>
                <th>{{ trans('common.size') }}</th>
                <th class="text-center">{{ trans('common.action') }}</th>
              </tr>
              </thead>
              <tbody>
              @foreach($files as $file)
                <tr>
                  <td>{{ HtmlEx::icon('admin.dbbackup.show', $file['name'], ['name' => $file['name']]) }}</td>
                  <td>{{ $file['date'] }}</td>
                  <td>{{ $file['size'] }}</td>
                  <td class="text-center">{{ HtmlEx::icon('admin.dbbackup.delete', $file['name'], ['name' => $file['name']]) }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          @else
            {{ trans('admin.dbbackup.none') }}
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
