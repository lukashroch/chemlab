@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header form-inline justify-content-between">
          <h6 class="card-title">{{ trans('admin.dbbackup') }}</h6>
          @include('partials.actions.create', ['resource' => 'admin.dbbackup'])
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
              <td>
              @include('partials.actions.detail', ['resource' => 'admin.dbbackup', 'entry' => $file])
              <td>{{ $file->date }}</td>
              <td>{{ $file->size }} KB</td>
              <td class="text-center">
                @include('partials.actions.show', ['resource' => 'admin.dbbackup', 'entry' => $file])
                @include('partials.actions.delete', ['resource' => 'admin.dbbackup', 'entry' => $file, 'response' => 'redirect'])
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
