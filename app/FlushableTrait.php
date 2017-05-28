<?php

namespace ChemLab;

trait FlushableTrait
{
    public static function bootFlushableTrait()
    {
        static::saved(function ($model) {
            //Cache::tags(strtolower(class_basename($model)))->flush();
            if (!isset(static::$cacheKeys) || empty(static::$cacheKeys))
                return;

            $class = strtolower(class_basename($model));
            foreach (static::$cacheKeys as $cacheKey) {
                if (cache()->has($class . '-' . $cacheKey))
                    cache()->forget($class . '-' . $cacheKey);
            }
        });
    }
}