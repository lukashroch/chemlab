@extends('app')

@section('title-content')
  {{ trans('department.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('department', 'index') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'department'])
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>{{ trans('department.name') }}</th>
            <th>{{ trans('department.prefix') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($departments as $department)
            <tr class="clickable" data-href="{{ route('department.show', ['id' => $department->id]) }}">
              <td>{{ HtmlEx::icon('department.show', $department->id, ['name' => $department->name]) }}</td>
              <td>{{ $department->prefix }}</td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('department.edit', $department->id) }}
                  {{ HtmlEx::icon('department.delete', $department->id, ['name' => $department->name]) }}
                </td>
              @endif
            </tr>
          @empty
            <tr class="warning">
              <th colspan="{{ $action ? '3' : '2'}}">{{ trans('common.query.empty') }}</th>
            </tr>
          @endforelse
          </tbody>
        </table>
        <tfoot>
        <tr>
          <th class="text-center" colspan="{{ $action ? '3' : '2'}}">{{ $departments->render() }}</th>
        </tr>
        </tfoot>
      </div>
    </div>
  </div>
@endsection
