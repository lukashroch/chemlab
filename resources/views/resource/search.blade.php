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
    <div class="col-sm-10 col-lg-8">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="row justify-content-center">
          @includeWhen($module != 'nmr', 'resource.search-input')
          @includeWhen(isset($selectName), 'resource.search-select')
      </div>
      @includeWhen($module == 'chemical', 'chemical.partials.search-advanced')
      {{ Form::close() }}
    </div>
    <div class="col-sm-1 col-lg-2 ml-auto">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

