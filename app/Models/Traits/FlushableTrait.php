<?php

namespace ChemLab\Models\Traits;

use ChemLab\Models\Interfaces\Flushable;
use Closure;
use Exception;
use Illuminate\Cache\TaggableStore;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

trait FlushableTrait
{
    /**
     * Cache model data
     *
     * @param string $key
     * @param Closure $callback
     * @param int $seconds
     * @return mixed
     */
    public static function cache($key, Closure $callback, $seconds = null)
    {
        $prefix = static::cachePrefix() . '_' . $key;

        return Cache::remember($prefix, $seconds ?? config('cache.ttl'), $callback);
    }

    /**
     * Get model cache prefix
     *
     * @return string
     */
    public static function cachePrefix()
    {
        return strtolower(class_basename(static::class));
    }

    /**
     * Boot Trait
     *
     * @return void
     */
    public static function bootFlushableTrait()
    {
        static::saved(function (Flushable $model) {
            $model->flushModelCache();
        });

        static::deleted(function (Flushable $model) {
            $model->flushModelCache();
        });

        // If model is using SoftDeletes
        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored(function (Flushable $model) {
                $model->flushModelCache();
            });
        }
    }

    /**
     * Flush Model cache data
     *
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function flushModelCache()
    {
        $cache = cache();
        $prefix = static::cachePrefix();
        // TODO: temp, need to clear managable stores based on user_id & permission_id
        if (in_array($prefix, ['user', 'store', 'role'])) {
            $cache->flush();
            return;
        }

        if ($cache->getStore() instanceof TaggableStore) {
            $cache->tags($prefix)->flush();
        } else {
            if (property_exists(static::class, 'cacheKeys') && !empty(static::$cacheKeys)) {
                foreach (static::$cacheKeys as $key) {
                    if ($cache->has($prefix . '_' . $key))
                        $cache->forget($prefix . '_' . $key);
                }
            }

            /*if (property_exists(static::class, 'cacheInstanceKeys') && !empty(static::$cacheInstanceKeys)) {
                foreach (static::$cacheInstanceKeys as $key => $value) {
                    foreach ($value::all() as $res) {
                        if (Cache::has($prefix . '_' . $key . '_' . $res->id))
                            Cache::forget($prefix . '_' . $key . '_' . $res->id);
                    }
                }
            }*/
        }
    }
}
