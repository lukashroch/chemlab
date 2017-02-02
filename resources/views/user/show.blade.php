@extends('app')

@section('title-content')
  {{ trans('user.title') }} | {{ $user->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'user', 'action' => 'show', 'data' => ['id' => $user->id, 'name' => $user->name]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'user', 'item' => $user, 'actions' => ['edit', 'delete']])
        <table class="table table-hover" id="user-view">
          <tbody>
          <tr>
            <th>{{ trans('user.name') }}</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('user.email') }}</th>
            <td>{{ $user->email }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.roles') }}</div>
        <table class="table table-hover">
            @forelse ($user->roles->sortBy('display_name') as $role)
            <tr>
              <td>{{ HtmlEx::icon('user.role', ['name' => $role->getDisplayNameWithDesc()]) }}</td>
            </tr>
            @empty
            <tr>
              <td>{{ trans('user.roles.none') }}</td>
            </tr>
          @endforelse
        </table>
      </div>
    </div>
  </div>
@endsection
