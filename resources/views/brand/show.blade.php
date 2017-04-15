@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name }}
@endsection

@section('head-content')
  @include('partials.header', ['module' => 'brand', 'action' => 'show', 'data' => ['name' => $brand->name]])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.panel-heading', ['module' => 'brand', 'item' => $brand, 'actions' => ['edit', 'delete']])
        <table class="table table-hover">
          <tbody>
          <tr>
            <th>{{ trans('brand.name') }}</th>
            <td>{{ $brand->name }}</td>
          </tr>
          <tr>
            <th>{{ trans('brand.url.product') }}</th>
            <td>{{ $brand->url_product }}</td>
          </tr>
          <tr>
            <th>{{ trans('brand.url.sds') }}</th>
            <td>{{ $brand->url_sds }}</td>
          </tr>
          <tr>
            <th>{{ trans('brand.parse-callback') }}</th>
            <td>{{ $brand->parse_callback }}</td>
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
