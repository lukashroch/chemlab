<div id="panel-heading-search" class="card-header">
  <div class="row">
    @if($module == 'chemical')
      <div class="col-sm-1 col-lg-2">
        <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
          <span class="fa fa-chevron-down" aria-hidden="true"></span>
          <span class="d-none d-lg-inline">{{ trans('chemical.search.advanced') }}</span>
        </a>
      </div>
    @endif
    <div class="col">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="form-group row">
        <div class="col-sm-12 col-lg-6">
          @includeWhen($module != 'nmr', 'resource.search-input')
        </div>
        <div class="col-sm-12 col-lg-6">
          @includeWhen(isset($selectName), 'resource.search-select')
        </div>
      </div>
      @includeWhen($module == 'chemical', 'chemical.partials.search-advanced')
    </div>
    {{ Form::close() }}
    <div class="col-sm-1 col-lg-2">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

