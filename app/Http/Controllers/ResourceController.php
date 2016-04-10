<?php namespace ChemLab\Http\Controllers;

class ResourceController extends Controller
{
    public function __construct()
    {
        $module = strtolower(str_replace('Controller', '', class_basename(static::class)));

        $this->middleware('auth');
        $this->middleware('permission:' . $module . '-show', ['only' => ['index', 'show', 'recent', 'search']]);
        $this->middleware('permission:' . $module . '-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:' . $module . '-delete', ['only' => ['delete', 'destroy']]);
    }

}
