@extends('app')

@section('title-content')
  {{ trans('permission.index') }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'permission', 'action' => 'index'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'permission'])
        <table id="permission-list" class="table table-striped table-hover table-list">
          <thead>
          <tr>
            <th>{{ trans('permission.name') }}</th>
            <th>{{ trans('permission.name.internal') }}</th>
            <th>{{ trans('permission.description') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($permissions as $permission)
            <tr class="clickable" data-href="{{ route('permission.show', ['id' => $permission->id]) }}">
              <td>{{ HtmlEx::icon('permission.show', $permission->id, ['name' => $permission->display_name]) }}</td>
              <td>{{ $permission->name }}</td>
              <td>{{ $permission->description }}</td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('permission.edit', $permission->id) }}
                  {{ HtmlEx::icon('permission.delete', $permission->id, ['name' => $permission->display_name]) }}
                </td>
              @endif
            </tr>
          @empty
            <tr class="warning">
              <th colspan="{{ $action ? '4' : '3'}}">{{ trans('common.query.empty') }}</th>
            </tr>
          @endforelse
          </tbody>
          <tfoot>
          <tr>
            <th class="text-center" colspan="{{ $action ? '4' : '3'}}">{{ $permissions->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
