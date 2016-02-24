<?php namespace ChemLab\Http\Controllers;

use Illuminate\Routing\Router;

class ResourceController extends Controller
{
    public function __construct(Router $router)
    {
        $route = $router->getCurrentRoute()->getName();
        $module = substr($route, 0, strpos($route, '.'));

        $this->middleware('auth');
        $this->middleware('permission:' . $module . '-show', ['only' => ['index', 'show', 'recent', 'search']]);
        $this->middleware('permission:' . $module . '-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:' . $module . '-delete', ['only' => ['delete', 'destroy']]);
    }

}
