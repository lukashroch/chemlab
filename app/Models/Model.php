<?php

namespace ChemLab\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Model extends BaseModel implements Auditable
{
    use AuditableTrait;
}
