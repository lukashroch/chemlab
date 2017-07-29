<?php

use Illuminate\Cache\TaggableStore;

function settings($key = null)
{
    $settings = app('ChemLab\Settings');
    return $key ? $settings->get($key) : $settings;
}

function path($path, $local = false)
{
    return $local ? $path : storage_path() . '/app/' . $path;
}

function localCache($prefix, &$key)
{
    $cache = cache();
    if ($cache->getStore() instanceof TaggableStore) {
        return $cache->tags($prefix);
    } else {
        $key = $prefix . "-" . $key;
        return $cache;
    }
}
