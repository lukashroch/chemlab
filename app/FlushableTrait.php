<?php

namespace ChemLab;

use Illuminate\Cache\TaggableStore;

trait FlushableTrait
{
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
        static::saved(function ($model) {
            $model->flushModelCache();
        });

        static::deleted(function ($model) {
            $model->flushModelCache();
        });
    }

    /**
     * Flush Model cache data
     *
     * @return void
     */
    public function flushModelCache()
    {
        $cache = cache();
        $prefix = static::cachePrefix();

        if ($cache->getStore() instanceof TaggableStore) {
            $cache->tags($prefix)->flush();
        } else {
            if (property_exists(static::class, 'cacheKeys') && !empty(static::$cacheKeys)) {
                foreach (static::$cacheKeys as $key) {
                    if ($cache->has($prefix . '_' . $key))
                        $cache->forget($prefix . '_' . $key);
                }
            }

            if (property_exists(static::class, 'modelCacheKeys') && !empty(static::$modelCacheKeys)) {
                foreach (static::$modelCacheKeys as $key => $value) {
                    foreach ($value::all() as $res) {
                        if ($cache->has($prefix . '_' . $key . '_' . $res->id))
                            $cache->forget($prefix . '_' . $key . '_' . $res->id);
                    }
                }
            }
        }
    }
}
