<?php

namespace ChemLab\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('credits');
    }

    public function index()
    {
        return view('home');
    }

    public function credits()
    {
        return view('credits');
    }
}
