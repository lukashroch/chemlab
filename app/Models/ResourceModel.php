<?php

namespace ChemLab\Models;

use ChemLab\Export\Exportable;
use ChemLab\Export\ExportableTrait;
use ChemLab\Models\Traits\ActionableTrait;

abstract class ResourceModel extends Model implements Exportable
{
    use ActionableTrait, ExportableTrait;
}
