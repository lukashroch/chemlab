<?php

namespace ChemLab;

use Laratrust\Models\LaratrustTeam;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Team extends LaratrustTeam implements Auditable
{
    use AuditableTrait;

    /**
     * Return team users
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Return children Store Models
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    /**
     * Get chemical items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*public function chemicalItems()
    {
        return $this->hasMany(ChemicalItem::class, 'owner_id', 'id');
    }*/

    /**
     * Get List of resources
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  bool|string $null
     * @param  string|null $column
     * @return array
     */
    public static function scopeSelectList($query, $null = false, $column = 'name')
    {
        $list = $query->orderBy($column, 'asc')->pluck($column, 'id')->toArray();

        if ($null != false)
            $list = [null => is_string($null) ? $null : trans('common.not-selected')] + $list;

        return $list;
    }
}
