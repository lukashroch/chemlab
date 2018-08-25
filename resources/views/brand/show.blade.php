@extends('app')

@section('title', $brand->name)

@section('content')
  <div class="card">
    @component('resource.header', ['resource' => 'brand', 'item' => $brand, 'actions' => ['edit', 'delete']])
      <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab" role="tab">{{ trans('common.info') }}</a>
      </li>
    @endcomponent

    <div class="tab-content">
      <div class="tab-pane active" id="info" role="tabpanel">
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
