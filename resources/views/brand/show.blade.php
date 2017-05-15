@extends('app')

@section('title-content')
  {{ trans('brand.title') }} | {{ $brand->name }}
@endsection

@section('content')
  @component('partials.resource-nav', ['module' => 'brand', 'action' => 'show'])
    <li class="breadcrumb-item">{{ $brand->name }}</li>
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        @component('partials.resource-header', ['module' => 'brand', 'item' => $brand, 'actions' => ['edit', 'delete']])
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
    </div>
  </div>
@endsection
