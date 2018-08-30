@extends('app')

@section('title')
  {{ trans('admin.title')}}
@endsection

@section('content')
  <div class="card">
    <div class="card-header form-inline justify-content-between">
      <h6 class="card-title">{{ trans('admin.index') }}</h6>
    </div>
    <table class="table table-hover">
      <thead>
      <tr>
        <th></th>
        <th>{{ trans('common.count') }}</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th>
          <span class="fas fa-fw fa-user-index"></span>
          {{ trans('user.index') }}
        </th>
        <td>{{ $count['users'] }}</td>
      </tr>
      <tr>
        <th>
          <span class="fas fa-fw fa-role-index"></span>
          {{ trans('role.index') }}
        </th>
        <td>{{ $count['roles'] }}</td>
      </tr>
      <tr>
        <th>
          <span class="fas fa-fw fa-permission-index"></span>
          {{ trans('permission.index') }}
        </th>
        <td>{{ $count['permissions'] }}</td>
      </tr>
      <tr>
        <th>
          <span class="fas fa-fw fa-team-index"></span>
          {{ trans('team.index') }}
        </th>
        <td>{{ $count['teams'] }}</td>
      </tr>
      <tr>
        <th>
          <span class="fas fa-fw fa-brand-index"></span>
          {{ trans('brand.index') }}
        </th>
        <td>{{ $count['brands'] }}</td>
      </tr>
      <tr>
        <th>
          <span class="fas fa-fw fa-store-index"></span>
          {{ trans('store.index') }}
        </th>
        <td>{{ $count['stores'] }}</td>
      </tr>
      <tr>
        <th><span class="fas fa-fw fa-chemical-index"></span>
          {{ trans('chemical.index') }}</th>
        <td>{{ $count['chemicals'] }}</td>
      </tr>
      </tbody>
    </table>
  </div>
@endsection
