<?php

namespace ChemLab\Models\Interfaces;

use Closure;

interface Flushable
{
    public static function cache($key, Closure $callback, $seconds = null);

    /**
     * Get model cache prefix
     *
     * @return string
     */
    public static function cachePrefix();

    /**
     * Boot Trait
     *
     * @return void
     */
    public static function bootFlushableTrait();

    /**
     * Flush Model cache data
     *
     * @return void
     */
    public function flushModelCache();
}
