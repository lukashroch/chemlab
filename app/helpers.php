<?php

use Illuminate\Cache\TaggableStore;

/**
 * Return User Settings by key or Settings instance
 *
 * @param string $key
 * @return mixed
 */
function settings($key = null)
{
    $settings = app('ChemLab\Settings');
    return $key ? $settings->get($key) : $settings;
}

/**
 * Return a local cache storage, whether it is TaggableStore or not
 * Prepend prefix to key if TaggableStore is not available
 *
 * @param string $prefix
 * @param string $key
 * @return mixed
 * @throws Exception
 */
function localCache($prefix, &$key)
{
    $cache = cache();
    if ($cache->getStore() instanceof TaggableStore) {
        return $cache->tags($prefix);
    } else {
        $key = $prefix . "_" . $key;
        return $cache;
    }
}
