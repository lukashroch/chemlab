<div id="panel-heading-search" class="card-header">
  <div class="row">
    <div class="col-sm-10">
      {{ Form::open(['url' => Request::path(), 'method' => 'get', 'id' => 'form-search']) }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group row">
            <div class="col-sm-1 col-lg-2">
              @if($module == 'chemical')
                <a data-toggle="collapse" href="#search-advanced" aria-expanded="false" aria-controls="search-advanced">
                  <span class="fa fa-chevron-down" aria-hidden="true"></span>
                  <span class="hidden-md-down">{{ trans('chemical.search.advanced') }}</span>
                </a>
              @endif
            </div>
            <div class="col-sm-11 col-lg-5">
              @includeWhen($module != 'nmr', 'resource.search-input')
            </div>
            <div class="col-sm-11 push-sm-1 push-lg-0 col-lg-5">
              @includeWhen(isset($selectName), 'resource.search-select')
            </div>
          </div>
        </div>
      </div>
      @includeWhen($module == 'chemical', 'chemical.partials.search-advanced')
    </div>
    {{ Form::close() }}
    <div class="col-sm-2">
      @include('partials.options', ['route' => route($module.".index")])
    </div>
  </div>
</div>

