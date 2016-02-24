@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('brand', 'show', array('id' => $brand->id, 'name' => $brand->name)) }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $brand->name }}</div>
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('brand.name') }}</th>
            <td>{{ $brand->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('brand.pattern') }}</th>
            <td>{{ $brand->pattern }}</td>
          </tr>
          <tr>
            <th>{{ trans('brand.description') }}</th>
            <td>{{ $brand->description }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
