<div class="btn-group btn-group-sm pull-right">
  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <span id="chemical-data-icon" class="fa fa-chemical-data" aria-hidden="true"></span> {{ trans('chemical.data') }}
    <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu" id="chemical-data-menu">
    <li><a href="#" name="all-data">{{ trans('chemical.data.all') }}</a></li>
    <li><a href="#" name="sigmaAldrich">{{ trans('chemical.data.sigma') }}</a></li>
    <li><a href="#" name="cactusNCI">{{ trans('chemical.data.cactus') }}</a></li>
    <li class="divider"></li>
    <li class="dropdown-header"><span class="fa fa-chemical-data-cactus-select fa-fw"
                                      aria-hidden="true"></span> {{ trans('chemical.data.cactus.select') }}</li>
    <li><a href="#" name="iupac_name">{{ trans('chemical.data.cactus.iupac') }}</a></li>
    <li><a href="#" name="cas">{{ trans('chemical.data.cactus.cas') }}</a></li>
    <li><a href="#" name="mw">{{ trans('chemical.data.cactus.mw') }}</a></li>
    <li><a href="#" name="formula">{{ trans('chemical.data.cactus.formula') }}</a></li>
    <li><a href="#" name="sdf">{{ trans('chemical.data.cactus.structure') }}</a></li>
    <li><a href="#" name="chemspider_id">{{ trans('chemical.data.cactus.chemspider') }}</a></li>
  </ul>
</div>