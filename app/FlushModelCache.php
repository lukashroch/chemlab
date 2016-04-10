<?php

namespace ChemLab;

use Illuminate\Support\Facades\Cache;

trait FlushModelCache
{
    public static function bootFlushModelCache()
    {
        static::saved(function ($model) {
            Cache::tags(strtolower(class_basename($model)))->flush();
        });
    }
}