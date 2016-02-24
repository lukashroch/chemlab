@extends('app')

@section('title-content')
  {{ trans('user.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('user', 'index') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'user'])
        <table class="table table-striped table-hover" id="user-list">
          <thead>
          <tr>
            <th>{{ trans('user.name') }}</th>
            <th>{{ trans('user.email') }}</th>
            <th>{{ trans('user.roles') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($users as $user)
            <tr class="clickable @if (!$user->roles->toArray()){{ 'warning' }}@endif"
                data-href="{{ route('user.show', ['id' => $user->id]) }}">
              <td>{{ HtmlEx::icon('user.show', $user->id, $user->name) }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @forelse (array_pluck($user->roles->toArray(), 'display_name') as $role)
                  {{ $role }}
                @empty
                  {{ trans('user.roles.none') }}
                @endforelse
              </td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('user.edit', $user->id) }}
                  {{ HtmlEx::icon('user.delete', $user->id, $user->name) }}
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
            <th class="text-center" colspan="{{ $action ? '4' : '3'}}">{{ $users->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
