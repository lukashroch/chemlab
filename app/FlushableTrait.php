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
            if (!isset(static::$cacheKeys) || empty(static::$cacheKeys))
                return;

            foreach (static::$cacheKeys as $cacheKey) {
                if ($cache->has($class . '-' . $cacheKey))
                    $cache->forget($class . '-' . $cacheKey);
            }
        }
    }
}
