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
            <a class="btn btn-sm btn-primary" href="{{ route('logs.show', ['name' => $file->name]) }}"
               title="{{ trans('common.action.detail') }}">
              <span class="fas fa-fw fa-file" title="{{ trans('common.action.detail') }}"></span>
            </a>
            <button class="btn btn-danger btn-sm delete" data-url="{{ route('logs.delete', ['id' => $file->name]) }}"
                    data-confirm="{{ trans('common.action.delete.confirm', ['name' => $file->name]) }}"
                    data-response="redirect" title="{{ trans('common.action.delete') }}">
              <span class="fas fa-fw fa-trash" title="{{ trans('common.action.delete') }}"></span>
            </button>
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
