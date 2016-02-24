@extends('app')

@section('title-content')
  {{ trans('role.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('role', 'index') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'role'])
        <table id="role-list" class="table table-striped table-hover">
          <thead>
          <tr>
            <th>{{ trans('role.name') }}</th>
            <th>{{ trans('role.name.internal') }}</th>
            <th>{{ trans('role.description') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($roles as $role)
            <tr class="clickable" data-href="{{ route('role.show', ['id' => $role->id]) }}">
              <td>{{ HtmlEx::icon('role.show', $role->id, $role->display_name) }}</td>
              <td>{{ $role->name }}</td>
              <td>{{ $role->description }}</td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('role.edit', $role->id) }}
                  {{ HtmlEx::icon('role.delete', $role->id, $role->display_name) }}
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
            <th class="text-center" colspan="{{ $action ? '4' : '3'}}">{{ $roles->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
