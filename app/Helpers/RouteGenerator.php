<?php

namespace ChemLab\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class RouteGenerator
{
    /**
     * Full class pathname
     *
     * @var string
     */
    private $model;

    /**
     * Class name
     *
     * @var string
     */
    private $class;

    /**
     * Resource parameter name
     *
     * @var string
     */
    private $name;

    /**
     * Resource name
     *
     * @var string
     */
    private $resource;

    /**
     * Controller name
     *
     * @var string
     */
    private $controller;

    /**
     * Extra routes to generate beyond base resource
     *
     * @var array
     */
    private $extras;

    /**
     * Allowed extra routes to generate
     *
     * @var array
     */
    private $allowedExtras = ['media', 'embeds'];

    /**
     * Class constructor
     *
     * @param string $model
     * @param array $extras
     */
    public function __construct(string $model, array $extras = [])
    {
        $this->model = $model;
        $this->class = class_basename($this->model);
        $this->name = Str::snake($this->class, '_');
        $this->resource = Str::plural(Str::snake($this->class, '-'));
        $this->controller = $this->class . "Controller";
        $this->extras = array_intersect($extras, $this->allowedExtras);

        $this->resource();
    }

    /**
     * Generate resource routes
     *
     * @return void
     */
    public function resource()
    {
        $name = $this->name;
        $resource = $this->resource;
        $controller = $this->controller;

        Route::get("{$resource}", "{$controller}@index")->name("{$resource}.index");
        Route::post("{$resource}", "{$controller}@store")->name("{$resource}.store");
        Route::get("{$resource}/create", "{$controller}@create")->name("{$resource}.create");
        Route::get("{$resource}/refs", "{$controller}@refs")->name("{$resource}.refs");
        Route::get("{$resource}/{{$name}}", "{$controller}@show")->name("{$resource}.show");
        Route::get("{$resource}/{{$name}}/edit", "{$controller}@edit")->name("{$resource}.edit");
        Route::get("{$resource}/{{$name}}/audit", "{$controller}@audit")->name("{$resource}.audit");
        Route::put("{$resource}/{{$name}}", "{$controller}@update")->name("{$resource}.update");
        Route::delete("{$resource}/{{$name}?}", "{$controller}@delete")->name("{$resource}.delete");

        foreach ($this->extras as $extra) {
            $this->{$extra}();
        }
    }

    /**
     * Additional class constructor
     *
     * @param string $model
     * @param array $extras
     * @return self
     */
    public static function create(string $model, array $extras = []): self
    {
        return new static($model, $extras);
    }
}
