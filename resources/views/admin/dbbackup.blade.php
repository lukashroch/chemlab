@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header form-inline justify-content-between">
          <h6 class="card-title">{{ trans('admin.dbbackup') }}</h6>
          {{ HtmlEx::icon('admin.dbbackup.create') }}
        </div>
        <table class="table table-sm table-striped table-hover table-list">
          <thead>
          <tr>
            <th>{{ trans('common.name') }}</th>
            <th>{{ trans('common.date') }}</th>
            <th>{{ trans('common.size') }}</th>
            <th class="text-center">{{ trans('common.action') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse($files as $file)
            <tr>
              <td>{{ HtmlEx::icon('admin.dbbackup.show', ['id' => $file['name'], 'name' => $file['name']]) }}</td>
              <td>{{ $file['date'] }}</td>
              <td>{{ $file['size'] }} KB</td>
              <td class="text-center">
                {{ HtmlEx::icon('admin.dbbackup.show', ['id' => $file['name']]) }}
                {{ HtmlEx::icon('admin.dbbackup.delete', ['id' => $file['name'], 'name' => $file['name'], 'response' => 'redirect']) }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">{{ trans('admin.dbbackup.none') }}</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
