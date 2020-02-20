<?php

namespace ChemLab\Http\Resources;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait AuditableTrait
{
    public function withAudit(): LengthAwarePaginator
    {
        $audit = $this->audits()->paginate(1);
        $item = $audit->getCollection()->first();

        $audit->setCollection(new Collection([
            'meta' => $item ? $item->getMetadata() : [],
            'modified' => $item ? $item->getModified() : []
        ]));

        return $audit;
    }
}
