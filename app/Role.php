<?php

namespace ChemLab;

use Yajra\Auditable\AuditableTrait;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use AuditableTrait, FlushableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * The cache keys, that are flushable
     *
     * @var array
     */
    protected static $cacheKeys = ['search'];

    /**
     * The cache keys, that are flushable and bound to specific Model instance and not just a Model
     * Workaround for not TaggableStore
     *
     * @var array
     */
    protected static $modelCacheKeys = ['stores' => Store::class, 'stores-user' => User::class];

    /**
     * Get manageable stores for role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * The formatted name with description
     *
     * @return string
     */
    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }

    /**
     * Get cached role's stores
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function cachedStores()
    {
        $id = $this->primaryKey;
        $key = 'stores-' . $this->$id;
        return localCache('role', $key)->rememberForever($key, function () {
            return $this->stores()->get();
        });
    }

    /**
     * Get data for search auto-completion
     *
     * @return array
     */
    public static function autocomplete()
    {
        $key = 'search';
        return localCache('role', $key)->rememberForever($key, function () {
            return static::select('display_name')->orderBy('display_name')->pluck('display_name')->toArray();
        });
    }
}
