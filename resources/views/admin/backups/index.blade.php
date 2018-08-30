@extends('app')

@section('title', trans('backups.title'))

@section('content')
  <div class="card">
    <div class="card-header">
      @permission('backups-create')
      <a role="button" class="btn btn-primary" href="{{ route('backups.create') }}"
         title="{{ trans('backups.new') }}">
        <span class="fas fa-plus" title="{{ trans('backups.new') }}"></span>
        {{ trans('backups.new') }}
      </a>
      @endpermission
    </div>
    <table class="table table-sm table-striped table-hover">
      <thead>
      <tr>
        <th>{{ trans('common.title') }}</th>
        <th>{{ trans('common.date') }}</th>
        <th>{{ trans('common.size') }}</th>
        <th class="text-center">{{ trans('common.action') }}</th>
      </tr>
      </thead>
      <tbody>
      @forelse($files as $file)
        <tr>
          <td>
            <span class="fas fa-fw fa-file-archive" title="{{ trans('common.action.detail') }}"></span>{{ $file->name }}
          <td>{{ $file->date }}</td>
          <td>{{ $file->size }} KB</td>
          <td class="text-center">
            @include('partials.actions.download', ['resource' => 'backups', 'entry' => $file, 'key' => 'name'])
            @include('partials.actions.delete', ['resource' => 'backups', 'entry' => $file, 'response' => 'redirect', 'key' => 'name'])
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">{{ trans('backups.none') }}</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
@endsection
