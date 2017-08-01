<?php

namespace ChemLab;

use Illuminate\Cache\TaggableStore;

trait FlushableTrait
{
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
        $class = strtolower(class_basename($this));

        if ($cache->getStore() instanceof TaggableStore) {
            $cache->tags($class)->flush();
        } else {
            if (property_exists(static::class, 'cacheKeys') && !empty(static::$cacheKeys)) {
                foreach (static::$cacheKeys as $key) {
                    if ($cache->has($class . '-' . $key))
                        $cache->forget($class . '-' . $key);
                }
            }

            if (property_exists(static::class, 'modelCacheKeys') && !empty(static::$modelCacheKeys)) {
                foreach (static::$modelCacheKeys as $key => $value) {
                    foreach ($value::all() as $res) {
                        if ($cache->has($class . '-' . $key . '-' . $res->id))
                            $cache->forget($class . '-' . $key . '-' . $res->id);
                    }
                }
            }
        }
    }
}
