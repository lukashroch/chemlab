<?php

use Illuminate\Cache\TaggableStore;
use Illuminate\Http\JsonResponse;

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
 * Return App's path
 *
 * @param string $path
 * @param bool $local
 * @return string
 */
function path($path, $local = false)
{
    return $local ? $path : storage_path() . '/app/' . $path;
}

/**
 * Return a local cache storage, whether it is TaggableStore or not
 * Prepend prefix to key if TaggableStore is not available
 *
 * @param string $prefix
 * @param string $key
 * @return mixed
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

/**
 * Return a new response from the application.
 *
 * @param $data
 * @param int $status
 * @return JsonResponse
 */
function responseJsonError(array $data, $status = 401)
{
    return response()->json($data, $status);
}
