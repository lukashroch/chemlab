<div id="datatable-header" class="card-header">
  <div class="row">
    @if($resource == 'chemical')
      <div class="col-auto">
        <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
          <span class="fas fa-chevron-down" aria-hidden="true"></span>
          <span class="d-none d-lg-inline">{{ trans('chemical.search.advanced') }}</span>
        </a>
      </div>
    @endif
    <div class="col">
      {{ Form::open(['url' => request()->path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="form-group form-row">
        @includeWhen($resource != 'nmr', 'resource.search-input')
        @includeWhen(isset($selectName), 'resource.search-select')
        <div class="col-auto">
          <button type="submit" class="btn btn-primary" title="{{ trans('common.search') }}">
            <span class="fas fa-search" title="{{ trans('common.search') }}"></span>
            {{ trans('common.search') }}
          </button>
        </div>
      </div>
      @includeWhen($resource == 'chemical', 'chemical.partials.search-advanced')
      {{ Form::close() }}
    </div>
  </div>
  <div class="row">
    <div class="col small">
      {{ trans('common.search.filter') }}: <span id="dtFilter"></span>
    </div>
    <div class="col-auto small">
      {{ trans('common.count.records') }}: <span id="dtCount"></span>
    </div>
  </div>
</div>
