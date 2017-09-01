<?php

namespace ChemLab;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Yajra\Auditable\AuditableTrait;

class Model extends BaseModel
{
    use AuditableTrait;
}
