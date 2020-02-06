<?php

namespace ChemLab\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display main page
     *
     * @return View
     */
    public function index(): View
    {
        return view('index');
    }

    /**
     * Invalid page
     *
     * @return JsonResponse
     */
    public function invalid(): JsonResponse
    {
        return response()->json(['invalid route'], 404);
    }
}
