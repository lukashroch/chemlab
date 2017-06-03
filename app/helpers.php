<?php

function settings($key = null)
{
    $settings = app('ChemLab\Settings');
    return $key ? $settings->get($key) : $settings;
}

function path($path, $local = false)
{
    return $local ? $path : storage_path() . '/app/' . $path;
}
