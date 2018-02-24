<div id="panel-heading-search" class="card-header">
  <div class="row">
    @if($module == 'chemical')
      <div class="col-auto">
        <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
          <span class="fa fa-chevron-down" aria-hidden="true"></span>
          <span class="d-none d-lg-inline">{{ trans('chemical.search.advanced') }}</span>
        </a>
      </div>
    @endif
    <div class="col">
      {{ Form::open(['url' => request()->path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="form-group form-row">
        @includeWhen($module != 'nmr', 'resource.search-input')
        @includeWhen(isset($selectName), 'resource.search-select')
        <div class="col-auto">
          {{ HtmlEx::icon('common.search') }}
        </div>
      </div>
      @includeWhen($module == 'chemical', 'chemical.partials.search-advanced')
      {{ Form::close() }}
    </div>
    <div class="col-auto">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

