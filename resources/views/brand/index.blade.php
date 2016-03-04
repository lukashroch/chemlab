@extends('app')

@section('title-content')
  {{ trans('brand.index') }}
@endsection

@section('head-content')
  {{ HtmlEx::menu('brand', 'index') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        @include('partials.search', ['module' => 'brand'])
        <table class="table table-striped table-hover">
          <thead>
          <tr>
            <th>{{ trans('brand.name') }}</th>
            <th>{{ trans('brand.description') }}</th>
            @if ($action)
              <th class="text-center">{{ trans('common.action') }}</th>
            @endif
          </tr>
          </thead>
          <tbody>
          @forelse($brands as $brand)
            <tr class="clickable" data-href="{{ route('brand.show', ['id' => $brand->id]) }}">
              <td>{{ HtmlEx::icon('brand.show', $brand->id, ['name' => $brand->name]) }}</td>
              <td>{{ $brand->description }}</td>
              @if ($action)
                <td class="text-center">
                  {{ HtmlEx::icon('brand.edit', $brand->id) }}
                  {{ HtmlEx::icon('brand.delete', $brand->id, ['name' => $brand->name]) }}
                </td>
              @endif
            </tr>
          @empty
            <tr class="warning">
              <th colspan="{{ $action ? '3' : '2'}}">{{ trans('common.query.empty') }}</th>
            </tr>
          @endforelse
          </tbody>
          <tfoot>
          <tr>
            <th class="text-center" colspan="{{ $action ? '3' : '2'}}">{{ $brands->render() }}</th>
          </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
