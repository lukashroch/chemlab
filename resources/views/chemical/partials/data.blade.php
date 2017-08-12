<div class="btn-group btn-group-sm">
  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <span id="chemical-data-icon" class="fa fa-chemical-data" aria-hidden="true"></span>
    <span class="d-none d-lg-inline">{{ trans('chemical.data') }}</span>
  </button>
  <div class="dropdown-menu dropdown-menu-right" role="menu" id="chemical-data-menu">
    <a class="dropdown-item" href="#" name="all-data">{{ trans('chemical.data.all') }}</a>
    <a class="dropdown-item" href="#" name="sigma-aldrich">{{ trans('chemical.data.sigma') }}</a>
    <a class="dropdown-item" href="#" name="cactus-nci">{{ trans('chemical.data.cactus') }}</a>
    <div class="dropdown-divider"></div>
    <h6 class="dropdown-header">
      <span class="fa fa-chemical-data-cactus-select fa-fw" aria-hidden="true"></span>
      {{ trans('chemical.data.cactus.select') }}
    </h6>
    <a class="dropdown-item" href="#" name="iupac_name">{{ trans('chemical.data.cactus.iupac') }}</a>
    <a class="dropdown-item" href="#" name="cas">{{ trans('chemical.data.cactus.cas') }}</a>
    <a class="dropdown-item" href="#" name="mw">{{ trans('chemical.data.cactus.mw') }}</a>
    <a class="dropdown-item" href="#" name="formula">{{ trans('chemical.data.cactus.formula') }}</a>
    <a class="dropdown-item" href="#" name="sdf">{{ trans('chemical.data.cactus.structure') }}</a>
    <a class="dropdown-item" href="#" name="chemspider_id">{{ trans('chemical.data.cactus.chemspider') }}</a>
  </div>
</div>