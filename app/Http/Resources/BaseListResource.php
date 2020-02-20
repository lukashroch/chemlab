<?php

namespace ChemLab\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseResource;

class BaseListResource extends BaseResource
{
    use ExportableTrait;
}
