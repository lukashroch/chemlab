@extends('app')

@section('title', trans('logs.title'))

@section('content')
  <div class="card">
    <div class="card-header">
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
            @include('partials.actions.show', ['resource' => 'logs', 'entry' => $file, 'key' => 'name'])
            @include('partials.actions.delete', ['resource' => 'logs', 'entry' => $file, 'response' => 'redirect', 'key' => 'name'])
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">{{ trans('logs.none') }}</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
@endsection
