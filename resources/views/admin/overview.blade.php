@extends('app')

@section('title-content')
  {{ trans('admin.title')}}
@endsection

@section('head-content')
  {{ trans('admin.title') }}
@endsection

@section('content')
  @include('admin.partials.menu')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-hover">
            <thead>
            <th></th>
            <th>{{ trans('common.count') }}</th>
            </thead>
            <tbody>
            <tr>
              <th>{{ HtmlEx::icon('user.index')}}</th>
              <td>{{ $count['users'] }}</td>
            </tr>
            <tr>
              <th>{{ HtmlEx::icon('role.index')}}</th>
              <td>{{ $count['roles'] }}</td>
            </tr>
            <tr>
              <th>{{ HtmlEx::icon('permission.index')}}</th>
              <td>{{ $count['permissions'] }}</td>
            </tr>
            <tbody>
            </tbody>
            <tr>
              <th>{{ HtmlEx::icon('brand.index')}}</th>
              <td>{{ $count['brands'] }}</td>
            </tr>
            <tr>
              <th>{{ HtmlEx::icon('store.index') }}</th>
              <td>{{ $count['stores'] }}</td>
            </tr>
            <tbody>
            </tbody>
            <tr>
              <th>{{ HtmlEx::icon('chemical.index') }}</th>
              <td>{{ $count['chemicals'] }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
